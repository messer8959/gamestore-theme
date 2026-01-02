import { TextControl, Button, IconButton } from '@wordpress/components';
import { URLInputButton, MediaPlaceholder } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function LogoRepeater({ logos, setAttributes }) {
    
    const addLogo = () => {
        const newLogos = [...logos, { url: '', image: '', imageDark: '' }];
        setAttributes({ logos: newLogos });
    };

    const updateLogo = (index, field, value) => {
        const newLogos = [...logos];
        newLogos[index][field] = value;
        setAttributes({ logos: newLogos });
    };

    const removeLogo = (index) => {
        const newLogos = [...logos];
        newLogos.splice(index, 1);
        setAttributes({ logos: newLogos });
    };

    return (
        <div className='logo-repeater'> 
            {logos.length > 0 && logos.map((logo, index) => (
                <div key={index} className='logo-repeater-item'>
                    {logo.image && (<img src={logo.image} alt={`Logo ${index + 1}`} style={{ maxWidth: "100px", marginBottom: "10px" }} />)}
                    <MediaPlaceholder
                        onSelect={(media) => updateLogo(index, "image", media.url)}
                        allowedTypes={['image']}
                        value={logo.image}
                        labels={{ title: 'Logo Image', instructions: 'Select or upload an image for the logo.' }}
                    />
                        <br/>
                    {logo.imageDark && (<img src={logo.imageDark} alt={`Logo ${index + 1}`} style={{ maxWidth: "100px", marginBottom: "10px" }} />)}
                    <MediaPlaceholder
                        onSelect={(media) => updateLogo(index, "imageDark", media.url)}
                        allowedTypes={['image']}
                        value={logo.image}
                        labels={{ title: 'Logo Image Dark', instructions: 'Select or upload an image for the logo.' }}
                    />
                    <br/>
                    <div style={{ marginTop: "10px" }}>
                        <label className="components-base-control__label">URL</label>
                        <URLInputButton
                            url={logo.url}
                            onChange={(value) => updateLogo(index, "url", value)}
                        />
                    </div>

                    <IconButton
                        icon="no-alt"
                        label="Remove"
                        onClick={() => removeLogo(index)}
                        className="remove-logo-btn"
                        style={{ marginTop: "12px" }}
                    />
                </div>
            ))}

            <Button
                variant="primary"
                onClick={addLogo}
                style={{ marginTop: "15px" }}
            >
                + Add Logo
            </Button>
        </div>
    );
}
