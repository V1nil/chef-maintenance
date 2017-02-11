<div class="product_data">
	<p class="description"><?php _e( 'Use this form to enter All in One SEO Pack details for this Product.', 'woo_ai' ); ?></p>
	<div id="all_in_one_seo" class="panel woocommerce_options_panel">
		<div class="options_group">
			<p class="form-field">
				<label for="woo_ai_aioseop_title"><?php _e( 'Title', 'woo_ai' ); ?></label>
				<input type="text" id="woo_ai_aioseop_title" name="aioseop_title" value="<?php echo $title; ?>" placeholder="" size="62"<?php disabled( $aioseop_enabled, false ); ?> />
				<img class="help_tip" data-tip="<?php _e( 'Most search engines use a maximum of 60 chars for the title.', 'woo_ai' ); ?>" src="<?php echo plugins_url( '/woocommerce/assets/images/help.png' ); ?>" />
			</p>
			<p class="form-field">
				<label for="woo_ai_aioseop_description"><?php _e( 'Description', 'woo_ai' ); ?></label>
				<textarea id="woo_ai_aioseop_description" name="aioseop_description" rows="3" cols="60"<?php disabled( $aioseop_enabled, false ); ?>><?php echo $description; ?></textarea>
				<img class="help_tip" data-tip="<?php _e( 'Most search engines use a maximum of 160 chars for the description.', 'woo_ai' ); ?>" src="<?php echo plugins_url( '/woocommerce/assets/images/help.png' ); ?>" />
			</p>
			<p class="form-field">
				<label for="woo_ai_aioseop_keywords"><?php _e( 'Keywords', 'woo_ai' ); ?></label>
				<input type="text" id="woo_ai_aioseop_keywords" name="aioseop_keywords" value="<?php echo $keywords; ?>" size="62"<?php disabled( $aioseop_enabled, false ); ?> />
				<img class="help_tip" data-tip="<?php _e( 'Keywords are comma separated. For instance: clothes, mens, shirts, t-shirt, etc.', 'woo_ai' ); ?>" src="<?php echo plugins_url( '/woocommerce/assets/images/help.png' ); ?>" />
			</p>
			<p class="form-field">
				<label for="woo_ai_aioseop_title_atr"><?php _e( 'Title atrributes', 'woo_ai' ); ?></label>
				<input type="text" id="woo_ai_aioseop_title_atr" name="aioseop_titleatr" value="<?php echo $title_atr; ?>" size="62"<?php disabled( $aioseop_enabled, false ); ?> />
			</p>
			<p class="form-field">
				<label for="woo_ai_aioseop_menu_label"><?php _e( 'Menu label', 'woo_ai' ); ?></label>
				<input type="text" id="woo_ai_aioseop_menu_label" name="aioseop_menulabel" value="<?php echo $menu_label; ?>" size="62"<?php disabled( $aioseop_enabled, false ); ?> />
			</p>
		</div>
		<div class="options_group">
			<p class="form-field">
				<label for="woo_ai_aioseop_disable"><?php _e( 'Disable Product', 'woo_ai' ); ?></label>
				<input type="checkbox" id="woo_ai_aioseop_disable" name="aioseop_disable" value="1" class="checkbox"<?php checked( $disable, 'on' ); ?><?php disabled( $aioseop_enabled, false ); ?> />
				 <img class="help_tip" data-tip="<?php _e( 'Disable on this Product.', 'woo_ai' ); ?>" src="<?php echo plugins_url( '/woocommerce/assets/images/help.png' ); ?>" />
			</p>
		</div>
	</div>
</div>