import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { title, description, questions, imageBg, image } = attributes;
	return (
		<div {...useBlockProps.save({
				className: 'alignFull',
				style: {
					backgroundImage: imageBg ? `url(${imageBg})` : 'none',
				}
			}) }>
			<div className='wrapper'>
					<RichText.Content
						tagName="h1"
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
						{questions.map((question, index) => (
							<div className='link-content' key={index}>
								
									{question.image && (<img src={question.image} />)}
									{question.anchor || "Unrilled Link"}
								
							</div>
						))}
					</div>
			</div>
		</div>
	);
}
