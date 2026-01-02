
import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, __experimentalDivider as Divider } from '@wordpress/components';
import './editor.scss';
import LinkRepeater from "./components/LinkRepeater";
import LogoRepeater from "./components/LogoRepeater";



export default function Edit({ attributes, setAttributes }) {
	const { copyrights, logos = [], links = [] } = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title="Footer Settings">
					<TextControl
						label="Copyrights"
						value={copyrights}
						onChange={(value) => setAttributes({ copyrights: value })}
					/>
					<Divider />
					<LinkRepeater
						links={links}
						setAttributes={setAttributes}
					/>
					<Divider />
					<LogoRepeater
						logos={logos}
						setAttributes={setAttributes}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()}>
				<div className="inner-footer">
					<InnerBlocks />
					<div className="footer-line"></div>
					<div className="footer-bottom">
						<div className="left-part">
							{copyrights && (<span className="copyrights">{copyrights}</span>
							)}
							{logos.length > 0 && (
								<div className="footer-logos">
									{logos.map((logo, index) => (
										<>
											<img key={index} src={logo.image} alt={logo.alt} className="footer-logo" />
											<img key={index} src={logo.imageDark} alt={logo.alt} className="footer-logo-dark" />

										</>
									))}
								</div>
							)}
						</div>
						<div className="right-part">
							{links.length > 0 && (
								<>
									{
										links.map((link, index) => (
											<a href={link.url} target={link.openInNewTab ? '_blank' : '_self'} rel={link.openInNewTab ? 'noopener noreferrer' : ''}>{link.anchor}</a>
										))
									}
								</>
							)}
						</div>
					</div>
				</div>
			</div>

		</>

	);
}
