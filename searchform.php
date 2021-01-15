<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'ellie' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Type to search', 'placeholder', 'ellie' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<span class="shadow_for_search"></span>
	</label>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'ellie' ); ?></span><i class="ellie-icon-search"></i></button>
</form>
