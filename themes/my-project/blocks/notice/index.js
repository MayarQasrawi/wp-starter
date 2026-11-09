/* Editor UI for my-project/notice. Plain JS, no build step. */
( function ( blocks, element, blockEditor, components, ServerSideRender ) {
	const el = element.createElement;

	blocks.registerBlockType( 'my-project/notice', {
		edit: function ( props ) {
			return el(
				element.Fragment,
				null,
				el(
					blockEditor.InspectorControls,
					null,
					el(
						components.PanelBody,
						{ title: 'Notice' },
						el( components.TextControl, {
							label: 'Message',
							value: props.attributes.message,
							onChange: function ( value ) {
								props.setAttributes( { message: value } );
							},
						} )
					)
				),
				el(
					'div',
					blockEditor.useBlockProps(),
					el( ServerSideRender, { block: 'my-project/notice', attributes: props.attributes } )
				)
			);
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.serverSideRender );
