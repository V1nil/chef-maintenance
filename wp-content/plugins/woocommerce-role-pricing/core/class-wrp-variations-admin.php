<?php
/**
 * class-wrp-variations-admin.php
 *
 * Copyright (c) "eggemplo" Antonio Blanco www.eggemplo.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 * 
 * @author Antonio Blanco
 * @package woorolepricinglight
 * @since 2.0
 */
if (! defined ( 'ABSPATH' )) {
	exit ();
}

/**
 * Variables product admin handlers.
 */
class WRP_Variations_Admin {
	
	/**
	 * Sets up the init action.
	 */
	public static function init() {
		// filter <del> tags for variable products
		add_filter('woocommerce_variable_sale_price_html', array ( __CLASS__, 'woocommerce_variable_sale_price_html' ), 10, 2 );
		add_filter('woocommerce_variable_sale_price', array ( __CLASS__, 'woocommerce_variable_sale_price_html' ), 10, 2 );

		// variations
		add_filter( 'woocommerce_get_variation_price', array ( __CLASS__, 'woocommerce_get_variation_price' ), 10, 4);

		// Get variation price. Added Woo 2.4
		add_filter( 'woocommerce_variation_prices_price', array ( __CLASS__, 'woocommerce_variation_prices' ), 10, 3);
		add_filter( 'woocommerce_variation_prices_regular_price', array ( __CLASS__, 'woocommerce_variation_prices' ), 10, 3);
		add_filter( 'woocommerce_variation_prices_sale_price', array ( __CLASS__, 'woocommerce_variation_prices' ), 10, 3);

		// Remove cache added in Woocommerce 2.4
		add_filter('woocommerce_get_variation_prices_hash', array ( __CLASS__, 'woocommerce_get_variation_prices_hash' ), 10, 3);

	}

	/**
	 * Filter <del> tabs for variable products
	 * @param String $pricehtml
	 * @param Object $product
	 * @return String
	 */
	public static function woocommerce_variable_sale_price_html ( $pricehtml, $product ) {
		global $post, $woocommerce;
	
		$string = $pricehtml;
		if ( ($post == null) || !is_admin() ) {
			$commission = WooRolePricingLight::get_commission( $product );
			if ( $commission ) { // if applying  discount, then remove the original prices.
				$string=preg_replace('/<del[^>]*>.+?<\/del>/i', '', $string);
			}
		}
		return $string;
	}
	
	public static function woocommerce_get_variation_price ( $price, $product, $min_or_max, $display ) {
		global $post, $woocommerce;
		
		$baseprice = $price;
		$result = $baseprice;
		
		if ( ($post == null) || !is_admin() ) {
			$variation_id = get_post_meta( $product->id, '_' . $min_or_max . '_price_variation_id', true );
	
			if ( ! $variation_id ) {
				return false;
			}
			
			$price        = get_post_meta( $variation_id, '_price', true );
			$result = $price;
			
			if ( $display ) {
					
				$variation        = $product->get_child( $variation_id );
	
				$commission = self::get_commission( $product, $variation_id );
					
				if ( $commission ) {
						
					$baseprice = $variation->get_regular_price();
			
					if ( $variation->get_sale_price() != $variation->get_regular_price() && $variation->get_sale_price() == $variation->price ) {
						if ( get_option( "wrp-baseprice", "regular" )=="sale" ) {
							$baseprice = $variation->get_sale_price();
						}
					}
					$product_price = $baseprice;
			
					$type = get_option( "wrp-method", "rate" );
					$result = 0;
					if ($type == "rate") {
						// if rate and price includes taxes
						if ( $variation->is_taxable() && get_option('woocommerce_prices_include_tax') == 'yes' ) {
							$_tax       = new WC_Tax();
							$tax_rates  = $_tax->get_shop_base_rate( $variation->tax_class );
							$taxes      = $_tax->calc_tax( $baseprice, $tax_rates, true );
							$product_price      = $_tax->round( $baseprice - array_sum( $taxes ) );
						}
			
						$result = WooRolePricingLight::bcmul($product_price, $commission, WOO_ROLE_PRICING_LIGHT_DECIMALS);
							
						if ( $variation->is_taxable() && get_option('woocommerce_prices_include_tax') == 'yes' ) {
							$_tax       = new WC_Tax();
							$tax_rates  = $_tax->get_shop_base_rate( $variation->tax_class );
							$taxes      = $_tax->calc_tax( $result, $tax_rates, false ); // important false
							$result      = $_tax->round( $result + array_sum( $taxes ) );
						}
					} else {
						if ( get_option( "wrp-haveset", "discounts" ) === 'discounts' ) {
							$result = WooRolePricingLight::bcsub($product_price, $commission, WOO_ROLE_PRICING_LIGHT_DECIMALS);
						} else {
							$result = $commission;
						}
					}
				}
			}
		}
		return $result;

	}

	/**
	 * Get woocommerce variation price discounted. Called the show the variation range price (category lists and product page).
	 * @param unknown $price
	 * @param unknown $variation
	 * @param unknown $product
	 * @return float
	 */
	public static function woocommerce_variation_prices ( $price, $variation, $product ) {
		global $post, $woocommerce;
	
		$baseprice = $price;
		$result = $baseprice;
	
		if ( ($post == null) || !is_admin() ) {
			$variation_id = $variation->variation_id;
	
			if ( ! $variation_id ) {
				return false;
			}
	
			$commission = self::get_commission( $product, $variation_id );
	
			if ( $commission ) {
	
				$price = get_post_meta( $variation_id, '_price', true );
				$result = $price;
	
				$baseprice = $variation->get_regular_price();
	
				if ( $variation->get_sale_price() != $baseprice && $variation->get_sale_price() == $variation->price ) {
					if ( get_option( "wrp-baseprice", "regular" )=="sale" ) {
						$baseprice = $variation->get_sale_price();
					}
				}
				$product_price = $baseprice;
	
				$type = get_option( "wrp-method", "rate" );
				$result = 0;
				if ($type == "rate") {
					// if rate and price includes taxes
					if ( $variation->is_taxable() && get_option('woocommerce_prices_include_tax') == 'yes' ) {
						$_tax       = new WC_Tax();
						$tax_rates  = $_tax->get_shop_base_rate( $variation->tax_class );
						$taxes      = $_tax->calc_tax( $baseprice, $tax_rates, true );
						$product_price      = $_tax->round( $baseprice - array_sum( $taxes ) );
					}
	
					$result = WooRolePricingLight::bcmul($product_price, $commission, WOO_ROLE_PRICING_LIGHT_DECIMALS);
	
					if ( $variation->is_taxable() && get_option('woocommerce_prices_include_tax') == 'yes' ) {
						$_tax       = new WC_Tax();
						$tax_rates  = $_tax->get_shop_base_rate( $variation->tax_class );
						$taxes      = $_tax->calc_tax( $result, $tax_rates, false ); // important false
						$result      = $_tax->round( $result + array_sum( $taxes ) );
					}
				} else {
					if ( get_option( "wrp-haveset", "discounts" ) === 'discounts' ) {
						$result = WooRolePricingLight::bcsub($product_price, $commission, WOO_ROLE_PRICING_LIGHT_DECIMALS);
					} else {
						$result = $commission;
					}
				}
			}
		}
	
		return $result;
	}

	/**
	 * Calculates the commissions.
	 * Order by priority:
	 * 1.- Variation values
	 * 2.- Product values
	 * 3.- Category values
	 * 4.- Default value
	 * @param unknown $product
	 * @param unknown $variation_id
	 * @return number
	 */
	public static function get_commission ( $product, $variation_id, $role = null ) {
		global $post, $woocommerce;
		global $wp_roles;
		global $current_user;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		$user_roles = $current_user->roles;

		$discount = 0;
		if ( sizeof( $wp_roles ) > 0 ) {
			if ( isset( $role ) ) {
				$first_group = $role;
			} else {
				$first_group = self::get_user_role( $user_roles, $product, $variation_id );
			}
			
			if ( get_option( "wrp-" . $first_group, "-1" ) !== "-1" ) {
				$discount = get_option( "wrp-" . $first_group );
			}
		}
		if ( $discount ) {
			$method = get_option( "wrp-method", "rate" );
			if ( $method == "rate" ) {
				if ( get_option( "wrp-haveset", "discounts" ) === 'discounts' ) {
					$discount = WooRolePricingLight::bcsub ( 1, $discount, WOO_ROLE_PRICING_LIGHT_DECIMALS );
				}
			}
		}
		return $discount;
	}

	/**
	 * Get the role applied to an user.
	 * @param array $roles
	 * @return role_name or null if an error occurs.
	 */
	public static function get_user_role( $roles = array(), $product, $variation_id ) {
		$result = null;
	
		if ( sizeof( $roles ) > 0 ) {
			$result = $roles[0];
		}
		return $result;
	}

	/**
	 * Remove cache added in Woocommerce 2.4 relating to variation prices.
	 * @param array $cache_key_args
	 * @param unknown $product
	 * @param unknown $display
	 * @return array
	 */
	public static function woocommerce_get_variation_prices_hash ( $hash, $product, $display ) {
	
		// Delete the cached data, if it exists
		$cache_key = 'wc_var_prices' . substr( md5( json_encode( $hash ) ), 0, 22 ) . WC_Cache_Helper::get_transient_version( 'product' );

		delete_transient($cache_key);

		// woocommerce 2.5.1
		delete_transient('wc_var_prices_' . $product->id);

		return $hash;
	}
}
WRP_Variations_Admin::init();
