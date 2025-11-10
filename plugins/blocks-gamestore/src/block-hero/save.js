
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { title, description, link, video, linkAnchor, image, slides } = attributes;
	return (
		<div {...useBlockProps.save()}>
			<div className='hero-content'>
				<RichText.Content
					tagName="h1"
					className="hero-title"
					value={title}
				/>
				<RichText.Content
					tagName="p"
					className="hero-description"
					value={description}
				/>
				{linkAnchor && (
					<a href={link} className="hero-button shadow">
						{linkAnchor}
					</a>
				)}
			</div>
			{video && (
				<video className='video-bg' loop="loop" autoplay="" muted playsinline width="100%" height="100%">
					<source className='source-element' src={video} type="video/mp4" />
				</video>
			)}
			{image && <img className='image-bg' src={image} alt="Hero Background" />}
			<div className='hero-mask'></div>
			{slides &&
				<div className='hero-slider'>
					<div className='slider-container'>
						<div className='slider-wrapper'>
							{slides.map((slide, index) => (
								<div className='slide-item' key={index}>
									{slide.lightImage && (
										<img
											src={slide.lightImage}
											alt={`Slide ${index + 1} Light Version`}
											className="light-logo"
										/>
									)}
									{slide.darkImage && (
										<img
											src={slide.darkImage}
											alt={`Slide ${index + 1} Dark Version`}
											className="dark-logo"
										/>
									)}
								</div>
							))}
						</div>
					</div>
				</div>

			}

		</div>
	);
}
