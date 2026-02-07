
import { useBlockProps, RichText, InspectorControls, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, ToggleControl } from '@wordpress/components';
import './editor.scss';
import { useState } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
	const { title, description, image, imageBg, buttonText, isReverse } = attributes;

	const [isReverseApplyed, setIsReverseApplyed] = useState(isReverse);

	return (
		<>
			<InspectorControls>
				<PanelBody title='Services Settings'>
					<TextControl
						label='Title'
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					<ToggleControl
						label='Reverse Content'
						checked={isReverseApplyed}
						onChange={(value) => {
							setIsReverseApplyed(value);
							setAttributes({ isReverse: value });
						}}
					/>
					
					<TextareaControl
						label='Description'
						value={description}
						onChange={(description) => setAttributes({ description })}
					/>
					{imageBg && (<img src={imageBg} />)}
					<MediaPlaceholder
						icon="format-image"
						labels={{ title: 'Background Image' }}
						onSelect={(media) => setAttributes({ imageBg: media.url })}
						accept='image/^'
						allowedTipes={['image']}
					/>
					{image && (<img src={image} />)}
					<MediaPlaceholder
						icon="format-image"
						labels={{ title: 'CTA Image' }}
						onSelect={(media) => setAttributes({ image: media.url })}
						accept='image/^'
						allowedTipes={['image']}
					/> <br /><br />
					<TextControl
						label='Button Text'
						value={buttonText}
						onChange={(buttonText) => setAttributes({ buttonText })}
					/>
				</PanelBody>


			</InspectorControls>
			<div {...useBlockProps({
				className: 'alignFull',
				style: {
					backgroundImage: imageBg ? `url(${imageBg})` : 'none',
				},
			})}>
				<div className={`wrapper cta-inner ${isReverseApplyed ? 'reverse' : ''}`}>
					<div className='left-part'>
						<RichText
							tagName="h2"
							className="cta-title"
							value={title}
							onChange={(title) => setAttributes({ title })}
						/>
						<RichText
							tagName="p"
							className="cta-description"
							value={description}
							onChange={(description) => setAttributes({ description })}
						/>
						<button className='hero-button shadow'>
							{buttonText || 'Get Started'}
						</button>
					</div>
					<div className='right-part'>
						{image && (
							<img className='image-cta' src={image} alt="CTA" />
						)}
					</div>
				</div>
			</div>
		</>
	);
}
