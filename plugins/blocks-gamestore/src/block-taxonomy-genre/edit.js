import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody} from '@wordpress/components';
import './editor.scss';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit({ attributes, setAttributes }) {
const { imageBg } = attributes;
	return (
		
			<div {...useBlockProps()}>
				<InspectorControls>
								<PanelBody title='CTA Settings'>
									{imageBg && (<img src={imageBg} />)}
									<MediaPlaceholder
										icon="format-image"
										labels={{ title: 'Background Image' }}
										onSelect={(media) => setAttributes({ imageBg: media.url })}
										accept='image/^'
										allowedTipes={['image']}
									/>
								</PanelBody>
							</InspectorControls>
				<ServerSideRender
				  block= "blocks-gamestore/single-genre"
				/>
			</div>
	);
}
