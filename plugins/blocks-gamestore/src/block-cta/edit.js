
import { useBlockProps, RichText, InspectorControls, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl} from '@wordpress/components';
import './editor.scss';
import { useState } from '@wordpress/element';
import LinkRepeater from "./components/LinkRepeater";

export default function Edit({ attributes, setAttributes }) {
	const { title, description, links, image, imageBg } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title='CTA Settings'>
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
				</PanelBody>
				<PanelBody>
					<LinkRepeater
						links={links}
						setAttributes={setAttributes}
					/>
				</PanelBody>


			</InspectorControls>
			<div {...useBlockProps({
				className: 'alignFull',
				style: {
					backgroundImage: imageBg ? `url(${imageBg})` : 'none',
				},
			})}>
				<div className='wrapper cta-inner'>
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
						<div className='links-list'>
							{links.map((link, index) => (
								<p key = {index}>
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
		</>
	);
}
