import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { title, description, image, imageBg, buttonText, isReverse } = attributes;
	return (
		<div {...useBlockProps.save({
				className: 'alignFull',
				style: {
					backgroundImage: imageBg ? `url(${imageBg})` : 'none',
				}
			}) }>
			<div className={`wrapper cta-inner ${isReverse ? 'reverse' : ''}`}>
				<div className='left-part'>
					<RichText.Content
						tagName="h2"
						className="cta-title"
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					<RichText.Content
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
	);
}
