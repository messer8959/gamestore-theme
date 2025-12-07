import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { title, description, links, imageBg, image } = attributes;
	return (
		<div {...useBlockProps.save({
				className: 'alignFull',
				style: {
					backgroundImage: imageBg ? `url(${imageBg})` : 'none',
				}
			}) }>
			<div className='wrapper cta-inner'>
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
					<div className='links-list'>
						{links.map((link, index) => (
							<p key={index}>
								<a href={link.url} target="_blank" rel="noopener noreferrer">
									{link.anchor || "Unrirled Link"}
								</a>
							</p>
						))}
					</div>
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
