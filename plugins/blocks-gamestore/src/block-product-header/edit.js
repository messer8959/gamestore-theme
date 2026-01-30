
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl } from '@wordpress/components';
import './editor.scss';
import LinkRepeater from "./components/LinkRepeater";

export default function Edit({ attributes, setAttributes }) {
	const { title, styleType, image, links } = attributes;
	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'blocks-gamestore')}>

					<TextControl
						label={__('Title', 'blocks-gamestore')}
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					<SelectControl
						label={__('Select type', 'blocks-gamestore')}
						value={styleType}
						onChange={(styleType) => setAttributes({ styleType })}
						options={[
							{ label: 'Archive Page', value: 'archive' },
							{ label: 'Single Page', value: 'single' },
						]}
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
				</PanelBody>
				{styleType !== 'archive' && (
					<PanelBody>
						<LinkRepeater
							links={links}
							setAttributes={setAttributes}
						/>
					</PanelBody>
				)}
			</InspectorControls>
			<div {...useBlockProps({
				className: 'alignFull',
				style: {
					backgroundImage: image ? `url(${image})` : 'none',
				}
			})}>
				<div className='wrapper'>
					<RichText
						tagName="h1"
						className="shop-header-title"
						value={title}
						onChange={(title) => setAttributes({ title })}
						placeholder={__('Add Title', 'blocks-gamestore')}
					/>
				</div>

			</div>
		</>
	);
}
