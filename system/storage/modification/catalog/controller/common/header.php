<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('setting/extension');

		$data['analytics'] = array();

		$analytics = $this->model_setting_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get('analytics_' . $analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get('analytics_' . $analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}


               $data['quickview'] = $this->load->controller('extension/module/pavquickview');
            


            $this->document->addStyle( 'catalog/view/javascript/pavobuilder/dist/pavobuilder.min.css' );
            $this->document->addScript( 'catalog/view/javascript/pavobuilder/dist/pavobuilder.min.js' );
        

            $data['pavothemer'] = $this->load->controller('extension/module/pavothemer');
            $id = $this->config->get( 'pavothemer_header_blockbuilder' );
            if( $id ){
                $data['pavoheader'] = '';
                $this->load->model( 'setting/module' );
                $setting_info = $this->model_setting_module->getModule( $id );

                if ($setting_info && $setting_info['status']) {
                    $data['pavoheader'] = $this->load->controller('extension/module/pavoheader' , $setting_info);
                }
            }

       

                // theme
                $theme = $this->config->get( 'config_theme' );
                // skin
                $skin = $this->config->get( 'pavothemer_default_skin' );
                /**
                * style files
                *
                * stylesheet file
                * stylesheet-rtl file
                * skin file
                */
                $styles = array(
                'stylesheet',
                $this->language->get( 'direction' ) === 'rtl' ? 'stylesheet-rtl' : '',
                'animate',
                $skin ? 'skins/' . $skin : '',
                'customize'
                );

                $this->document->addStyle( 'catalog/view/javascript/pavobuilder/dist/pavobuilder.min.css' );
                foreach ( $styles as $style ) {
                if ( ! $style ) continue;
                $style = DIR_TEMPLATE . $theme . '/stylesheet/' . $style;
                $file = false;
                if ( file_exists( $style . '.min.css' ) ) {
                $file = $style . '.min.css';
                } else if ( file_exists( $style . '.css' ) ) {
                $file = $style . '.css';
                }
                if ( $file ) {
                $file = str_replace( DIR_APPLICATION, basename( DIR_APPLICATION ) . '/', $file );
                $this->document->addStyle( $file );
                }
                }

                $google_api_key = $this->config->get( 'pavothemer_google_map_api_key' );
                $this->document->addScript( '//maps.googleapis.com/maps/api/js?key=' .$google_api_key );
                /**
                * script files
                *
                * common script
                * customize script
                */
                $coreScripts = array(
                'pavobuilder/dist/pavobuilder.min.js',
                'pavothemer/dist/pavothemer.min.js'
                );

                foreach ( $coreScripts as $script ) {
                $file = dirname ( DIR_TEMPLATE ) . '/javascript/' . $script;
                if ( file_exists( $file ) ) {
                $file = str_replace( DIR_APPLICATION, basename( DIR_APPLICATION ) . '/', $file );
                $this->document->addScript( $file );
                }
                }
                $scripts = array(
                'common',
                'customize'
                );

                foreach ( $scripts as $script ) {
                $script = DIR_TEMPLATE . $theme . '/javascript/' . $script;
                $file = false;

                if ( file_exists( $script . '.min.js' ) ) {
                $file = $script . '.min.js';
                } else if ( file_exists( $script . '.js' ) ) {
                $file = $script . '.js';
                }

                if ( $file ) {
                $file = str_replace( DIR_APPLICATION, basename( DIR_APPLICATION ) . '/', $file );
                $this->document->addScript( $file );
                }
                }
		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts('header');
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		$data['quickview'] = $this->load->controller('extension/module/pavquickview');

		// Pavothemes codes
		$data['theme_name'] = $this->config->get('config_theme');
		
		if ($data['direction'] == 'rtl' && file_exists(DIR_TEMPLATE. $data['theme_name'] .'/stylesheet/stylesheet-rtl.css') ) {
			$data['css_file_rtl'] = 'catalog/view/theme/'. $data['theme_name'] .'/stylesheet/stylesheet-rtl.css';
		}

		$data['theme_skins'] = $this->config->get('pavothemer_default_skin');
		// End---------

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));
		
		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

                $data['facebook_app_id'] = $this->config->get('pavoblog_facebook_appid');
            
		
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		$data['menu'] = $this->load->controller('common/menu');

                //Call Pav megamenu module to display
                $data['pavmegamenu'] = $this->load->controller('extension/module/pavmegamenu');
            
		
		
        $data['body_class'] = $this->getBodyClass();
        // pavothemer header layout file
         
        
        $data['body_class'] = $this->getBodyClass();
        // pavothemer header layout file
        $data['pavothemer_theme_width'] = $this->config->get( 'pavothemer_theme_width' );
        $data['pavothemer_layout']      = $this->config->get( 'pavothemer_layout' );
        $header = $this->config->get( 'pavothemer_header_layout' );

        $file = DIR_TEMPLATE . $theme . '/template/common/' . $header . '.twig';
        if ( $header && file_exists( $file ) ) {
            return $this->load->view('common/' . $header, $data);
        } else {
            return $this->load->view('common/header', $data);
        }

    }

    
             
    

    /**
     * Get body class
     */
    public function getBodyClass() {
        $route = ! empty( $this->request->get['route'] ) ? $this->request->get['route'] : 'common/home';

        $class = "" ; 
        if( $this->config->get( 'pavothemer_keepheader' ) ){
            $class = ' has-header-sticky';
        }

        return 'page-' . implode( '-', explode( '/', $route ) ) . $class;
            
	}
}
