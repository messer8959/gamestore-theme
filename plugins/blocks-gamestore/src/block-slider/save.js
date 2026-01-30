
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { title, description, slides } = attributes;
	return (
		<div {...useBlockProps.save({ className: "alignfull" })}>
			<div className='slider-inner-content'>
				<RichText.Content
					tagName="h1"
					className="slider-title"
					value={title}
					onChange={(title) => setAttributes({ title })}
				/>
				<RichText.Content
					tagName="p"
					className="slider-description"
					value={description}
				/>
				{slides &&

					<div className='slider-media'>
						<div className='slider-wrapper2'>
							{slides.map((slide, index) => (
								<div className='slide-item' key={index}>
									{slide.image && (
										<img
											src={slide.image}
											alt={`Slide ${index + 1} Light Version`}
											className="blur-image"
										/>
									)}
									{slide.darkImage && (
										<img
											src={slide.darkImage}
											alt={`Slide ${index + 1} Dark Version`}
											className="original-image"
										/>
									)}
								</div>
							))}
						</div>
					</div>


				}
			</div>

		</div>
	);
}
