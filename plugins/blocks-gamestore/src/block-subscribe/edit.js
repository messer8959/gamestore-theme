
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
	const { shortcode, title, description, image } = attributes;
	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'blocks-gamestore')}>
					<TextControl
						label={__('Title', 'blocks-gamestore')}
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					<TextareaControl
						label={__('Description', 'blocks-gamestore')}
						value={description}
						onChange={(description) => setAttributes({ description })}
					/>
					{image && (<img src={image} />)}
					<MediaPlaceholder	
						icon="format-image"
						labels={{ title: 'Image' }}
						onSelect={(media) => setAttributes({ image: media.url })}
						accept='image/^'
						allowedTipes={['image']}
						notices={['image']}
					/>
					<TextControl
						label={__('Shortcode', 'blocks-gamestore')}
						value={shortcode}
						onChange={(val) => setAttributes({ shortcode: val })}
					/>
				</PanelBody>
			</InspectorControls>	
			<div {...useBlockProps({
				className: 'alignFull',
				style: {
					backgroundImage: image ? `url(${image})` : 'none',
				}
			})}>
				<div className="subscribe-inner wrapper">
					<RichText
						tagName="h2"
						className="subscribe-title"
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					<RichText
						tagName="p"
						className="subscribe-description"
						value={description}
						onChange={(description) => setAttributes({ description })}
					/>
				</div>
			</div>
		</>
	);
}
