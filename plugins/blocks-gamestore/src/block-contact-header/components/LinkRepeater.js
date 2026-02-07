import { TextControl, Button, IconButton } from '@wordpress/components';
import { URLInputButton, MediaPlaceholder } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function questionRepeater({ questions, setAttributes }) {

    const addquestion = () => {
        const newquestions = [...questions, { anchor: '', url: '', image: '' }];
        setAttributes({ questions: newquestions });
    };

    const updatequestion = (index, field, value) => {
        const newquestions = [...questions];
        newquestions[index][field] = value;
        setAttributes({ questions: newquestions });
    };

    const removequestion = (index) => {
        const newquestions = [...questions];
        newquestions.splice(index, 1);
        setAttributes({ questions: newquestions });
    };

    return (
        <div className='question-repeater'>
            {questions.length > 0 && questions.map((question, index) => (
                <div key={index} className='question-repeater-item'>

                    <TextControl
                        label="Anchor Text"
                        value={question.anchor}
                        placeholder="Enter anchor..."
                        onChange={(value) => updatequestion(index, "anchor", value)}
                    />

                    <div style={{ marginTop: "10px" }}>
                        <label className="components-base-control__label">URL</label>
                        <URLInputButton
                            url={question.url}
                            onChange={(value) => updatequestion(index, "url", value)}
                        />
                        <MediaPlaceholder
                        icon="format-image"
                        labels={{ title: 'Question Image' }}
                        onSelect={(media) => updatequestion(index, "image", media.url)}
                        accept='image/^'
                        allowedTipes={['image']}
                    />
                    <div>
                        Images
                        {question.image && (<img src={question.image} />)}
                    </div>
                    
                    </div>

                    <div style={{ marginTop: "10px" }}>
                    
                     
                    </div>
                    <IconButton
                        icon="no-alt"
                        label="Remove"
                        onClick={() => removequestion(index)}
                        className="remove-question-btn"
                        style={{ marginTop: "12px" }}
                    />
                </div>
            ))}

            <Button
                variant="primary"
                onClick={addquestion}
                style={{ marginTop: "15px" }}
            >
                + Add question
            </Button>
        </div>
    );
}
