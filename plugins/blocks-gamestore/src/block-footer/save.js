
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';


export default function save({ attributes }) {
	const { copyrights, logos, links } = attributes;
	return (
		<>
			<div {...useBlockProps.save()}>
				<div className='wrapper inner-footer'>
					<div className="inner-footer">
						<InnerBlocks.Content />
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
										{links.map((link, index) => (

											<a href={link.url} target={link.openInNewTab ? '_blank' : '_self'} rel={link.openInNewTab ? 'noopener noreferrer' : ''}>{link.anchor}</a>

										))}
									</>
								)}
							</div>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
