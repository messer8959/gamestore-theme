
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, Button, ToggleControl } from '@wordpress/components';
import './editor.scss';
import { useState } from 'react';

const FAQItem = ({ faq, index, onTitleChange, onDescriptionChange, onRemove }) => {
	return (
		<div className='faq-item'>
			<TextControl
				label='Title'
				value={faq.title}
				onChange={(title) => onTitleChange(title, index)}
			/>
			<TextareaControl
				label='Answer'
				value={faq.description}
				onChange={(description) => onDescriptionChange(description, index)}
			/>
			<Button
				className='components-button is-secondary'
				isDestructive
				onClick={() => onRemove(index)}
			>
				Remove item
			</Button>
		</div>
	);
};

export default function Edit({ attributes, setAttributes }) {
	const { title, margin } = attributes;
	const [faqs, setFaqs] = useState(attributes.faqs || []);

	const onFAQChange = (updatedFAQ, index) => {
		const updatedFaqs = [...faqs];
		updatedFaqs[index] = updatedFAQ;
		setFaqs(updatedFaqs);
		setAttributes({ faqs: updatedFaqs });
	};

	const addFAQ = () => {
		setFaqs([...faqs, { title: '', description: '' }]);
	};

	const handleTitleChange = (newTitle, index) => {
		const updatedFAQ = { ...faqs[index], title: newTitle };
		onFAQChange(updatedFAQ, index);
	};
	const handleDescriptionChange = (newDescription, index) => {
		const updatedFAQ = { ...faqs[index], description: newDescription };
		onFAQChange(updatedFAQ, index);
	};
	const removeFAQ = (index) => {
		const updatedFaqs = [...faqs];
		updatedFaqs.splice(index, 1);
		setFaqs(updatedFaqs);
		setAttributes({ faqs: updatedFaqs });
	}

	return (
		<>
			<InspectorControls>
				<PanelBody title='FAQs Settings'>
					<TextControl
						label='Title'
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					<ToggleControl
						label='Margin Zero'
						checked={margin}
						onChange={(value) => setAttributes({ margin: value })}
					/>
					{faqs.map((faq, index) => (
						<FAQItem
							key={index}
							faq={faq}
							index={index}
							onTitleChange={handleTitleChange}
							onDescriptionChange={handleDescriptionChange}
							onRemove={removeFAQ}
						/>
					))}
					<Button className='components-button is-primary' onClick={addFAQ}>
						Add FAQ
					</Button>
				</PanelBody>
				<PanelBody title='Manage FAQs'>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps({ className: margin ? 'no-margin' : '' })}>
				<div className='wrapper faq-inner'>
					<RichText
						tagName="h2"
						className="faq-title"
						value={title}
						onChange={(title) => setAttributes({ title })}
					/>
					{faqs.map((faq, index) => (
						<div key={index} className='faq-item'>
							<RichText
								tagName="div"
								className="faq-item-title"
								value={faq.title}
								onChange={(newTitle) => handleTitleChange( newTitle, index )}
							/>
							<RichText
								tagName="div"
								className="faq-item-description"
								value={faq.description}
								onChange={(newDescription) => handleDescriptionChange( newDescription, index )}
							/>
						</div>
					))}
				</div>
			</div>
		</>
	);
}
