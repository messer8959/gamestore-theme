import { TextControl, Button, IconButton } from '@wordpress/components';
import { URLInputButton } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function LinkRepeater({ links, setAttributes }) {
    
    const addLink = () => {
        const newLinks = [...links, { anchor: '', url: '' }];
        setAttributes({ links: newLinks });
    };

    const updateLink = (index, field, value) => {
        const newLinks = [...links];
        newLinks[index][field] = value;
        setAttributes({ links: newLinks });
    };

    const removeLink = (index) => {
        const newLinks = [...links];
        newLinks.splice(index, 1);
        setAttributes({ links: newLinks });
    };

    return (
        <div className='link-repeater'> 
            {links.length > 0 && links.map((link, index) => (
                <div key={index} className='link-repeater-item'>
                    
                    <TextControl
                        label="Anchor Text"
                        value={link.anchor}
                        placeholder="Enter anchor..."
                        onChange={(value) => updateLink(index, "anchor", value)}
                    />

                    <div style={{ marginTop: "10px" }}>
                        <label className="components-base-control__label">URL</label>
                        <URLInputButton
                            url={link.url}
                            onChange={(value) => updateLink(index, "url", value)}
                        />
                    </div>

                    <IconButton
                        icon="no-alt"
                        label="Remove"
                        onClick={() => removeLink(index)}
                        className="remove-link-btn"
                        style={{ marginTop: "12px" }}
                    />
                </div>
            ))}

            <Button
                variant="primary"
                onClick={addLink}
                style={{ marginTop: "15px" }}
            >
                + Add Link
            </Button>
        </div>
    );
}
