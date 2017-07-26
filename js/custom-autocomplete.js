
	$.widget( "ui.autocomplete", $.ui.autocomplete, {
	 
		 options: {
				renderItem: null,
				renderMenu: null
		 },
	 
		 _renderItem: function( ul, item ) {
				if ( $.isFunction( this.options.renderItem ) )
					 return this.options.renderItem( ul, item );
				else
					 return this._super( ul, item );
		 },
	 
		 _renderMenu: function( ul, items ) {
	 
				if ( $.isFunction( this.options.renderMenu ) ) {
	 
					 this.options.renderMenu( ul, items );
	 
				}
	 
				this._super( ul, items );
		 },
	 
	});
