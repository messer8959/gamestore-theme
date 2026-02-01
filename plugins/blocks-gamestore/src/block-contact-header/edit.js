
import { useBlockProps, RichText, InspectorControls, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import './editor.scss';
import { useState } from '@wordpress/element';
import LinkRepeater from "./components/LinkRepeater";

export default function Edit({ attributes, setAttributes }) {
	const { title, description, questions, imageBg } = attributes;

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
				</PanelBody>
				<PanelBody>
					<LinkRepeater
						questions={questions}
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
							{questions.map((question, index) => (
								<div className='link-content' key={index}>

									{question.image && (<img src={question.image} />)}
									{question.anchor || "Unrilled Link"}

								</div>
							))}
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
