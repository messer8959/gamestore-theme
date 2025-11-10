
import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, ToggleControl, Button } from '@wordpress/components';
import './editor.scss';
import { useState } from '@wordpress/element';

const SlideItem = ({ index, slide, onImageChange, onRemove }) => {
	return (
		<>
			<div className='slide-item'>
				<div className='slide-item-image'>
					<p>Light Version</p>
					{slide.lightImage && <div className='image-box'><img src={slide.lightImage} alt="Slide Image" /></div>
					}
					{/* {console.log(slide)} */}
					<MediaPlaceholder
						icon="format-image"
						onSelect={(media) => onImageChange(media.url, index, "lightImage")}
						onSelectURL={(url) => onImageChange(url, index, "lightImage")}
						labels={{
							title: 'Slide Light Image',
							instructions: 'Upload an image for the slide'
						}}
						accept="image/*"
						allowedTypes={['image']}
						multiple={false}
					/>
				</div>

				<div className='slide-item-image'>
					<p>Dark Version</p>
					{slide.darkImage && <div className='image-box'><img src={slide.darkImage} alt="Slide Image" /></div>}
					{/* {console.log(slide)} */}
					<MediaPlaceholder
						icon="format-image"
						onSelect={(media) => onImageChange(media.url, index, "darkImage")}
						onSelectURL={(url) => onImageChange(url, index, "darkImage")}
						labels={{
							title: 'Slide Dark Image',
							instructions: 'Upload an image for the slide'
						}}
						accept="image/*"
						allowedTypes={['image']}
						multiple={false}
					/>
				</div>

				<Button className="components-button is-destructive" onClick={() => onRemove(index)}>
					Remove Slide
				</Button>
			</div>
		</>
	);
}

export default function Edit({ attributes, setAttributes }) {
	const { title, description, link, video, linkAnchor, image, isVideo, slides: initialSlides } = attributes;
	const [isVideoUpload, setVideoUpload] = useState(isVideo);

	const [slides, setSlides] = useState(initialSlides || []);

	const onSlideChange = (updatedSlide, index) => {
		const updatedSlides = [...slides];
		// console.log(slides)
		updatedSlides[index] = updatedSlide;
		setSlides(updatedSlides);
		setAttributes({ slides: updatedSlides });
	}

	const addSlide = () => {
		const newSlide = { lightImage: '', darkImage: '' };
		const updatedSlides = [...slides, newSlide];
		setSlides(updatedSlides);
		setAttributes({ slides: updatedSlides });
	}

	const removeSlide = (index) => {
		const updatedSlides = [...slides];
		updatedSlides.splice(index, 1);
		setSlides(updatedSlides);
		setAttributes({ slides: updatedSlides });
	}

	const handleImageChange = (url, index, imageType) => {
		// console.log(slides)
		const updatedSlide = { ...slides[index], [imageType]: url };
		onSlideChange(updatedSlide, index);
	}

	return (
		<>
			<InspectorControls>
				<PanelBody title='Hero Settings'>
					<TextControl
						label='Title'
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					<TextareaControl
						label='Description'
						value={description}
						onChange={(description) => setAttributes({ description })}
					/>
					<TextControl
						label='Button URL'
						value={link}
						onChange={(link) => setAttributes({ link })}
					/>
					<TextControl
						label='Button Value'
						value={linkAnchor}
						onChange={(linkAnchor) => setAttributes({ linkAnchor })}
					/>
					<ToggleControl
						label='Upload Video'
						checked={isVideoUpload}
						onChange={(value) => {
							setVideoUpload(value);
							setAttributes({ isVideo: value, video: '', image: '' });
						}}
					/>
					{isVideoUpload ? (
						video && (
							<video controls muted>
								<source src={video} type="video/mp4" />
							</video>
						)
					) : (
						image && <img src={image} alt="Uploaded" />
					)
					}
					<MediaUpload
						onSelect={(media) => {
							if (isVideoUpload) {
								setAttributes({ video: media.url });
							} else {
								setAttributes({ image: media.url });
							}
						}}
						type={isVideoUpload ? ['video'] : ['image']}
						render={({ open }) => (
							<button className='components-button is-secondary image-upload' onClick={open}>
								{isVideoUpload ? 'Uploa Video' : 'Upload Image'}
							</button>
						)}
					/>

					{/* {video && (
						<video controls muted>
							<source src={video} type="video/mp4" />	
						</video>
					)}
					<MediaUpload
						onSelect={(media) => setAttributes({ video: media.url })}
						type={['video']}
						render={({ open }) => (
							<button className='components-button is-secondary video-upload' onClick={open}>
								Upload Video
							</button>
						)}
					/>	 */}
				</PanelBody>
				<PanelBody title='Hero Slider'>
					{/* {slides.forEach((slide, index) => {
						<SlideItem
							key={index}
							index={index}
							slide={slide}
							onImageChange={handleImageChange}
							onRemove={removeSlide}
						/>
					})} */}
					{slides.map((slide, index) => (
						<SlideItem
							key={index}
							index={index}
							slide={slide}
							onImageChange={handleImageChange}
							onRemove={removeSlide}
						/>
					))}
					<Button className="components-button is-primary" onClick={addSlide}>
						Add Slide
					</Button>
				</PanelBody>

			</InspectorControls>
			<div {...useBlockProps()}>
				{video && (
					<video className='videp-bg' loop="loop" autoplay="" muted playsinline width="100%" height="100%">
						<source className='source-element' src={video} type="video/mp4" />
					</video>
				)}
				{image && (
					<img className='image-bg' src={image} alt="Hero Background" />
				)}
				<div className='hero-mask'></div>
				<div className='hero-content'>
					<RichText
						tagName="h1"
						className="hero-title"
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					<RichText
						tagName="p"
						className="hero-description"
						value={description}
						onChange={(description) => setAttributes({ description })}
					/>
					{linkAnchor && (
						<a href={link} className="hero-button shadow">
							{linkAnchor}
						</a>
					)}

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
			</div>
		</>
	);
}
