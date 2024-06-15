import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

const Questionnaire = () => {
    const { questionnaireid, studentid } = useParams();
    const [data, setData] = useState(null);
    const [message, setMessage] = useState('');

    useEffect(() => {
        axios.get(`/api/questionnaires/${questionnaireid}/student/${studentid}`)
            .then((res) => setData(res.data))
            .catch((err) => {
                console.error(err);
                setMessage('Error while loading questionnaire.');
            });
    }, [questionnaireid, studentid]);

    const handleSubmit = async (event) => {
        event.preventDefault();
        const formData = new FormData(event.target);
        const answers = {};

        formData.forEach((value, key) => {
            if (key.startsWith('answer_')) {
                const questionId = key.replace('answer_', '');
                answers[questionId] = value;
            }
        });

        const payload = {
            student_id: studentid,
            questionnaire_id: questionnaireid,
            answers: answers
        };

        try {
            const response = await axios.post('/api/responses/store', payload);
            alert(response.data.message);
        } catch (error) {
            console.error(error);
            alert('An error occurred while submitting your responses.');
        }
    };

    if (message) {
        return <div>{message}</div>;
    }

    if (!data) {
        return <div>Loading...</div>;
    }

    return (
        <div>
            <h1>{data.questionnaire.title}</h1>
            <form onSubmit={handleSubmit}>
                <input type="hidden" name="student_id" value={studentid} />
                <input type="hidden" name="questionnaire_id" value={questionnaireid} />
                {data.questions.map((question, index) => (
                    <div key={index}>
                        <p>{question.question}</p>
                        {JSON.parse(question.options).map((option, optIndex) => (
                            <label key={optIndex}>
                                <input
                                    type="radio"
                                    name={`answer_${question.id}`}
                                    value={option}
                                    required
                                />
                                {option}
                                <br />
                            </label>
                        ))}
                    </div>
                ))}
                <button type="submit">Submit</button>
            </form>
        </div>
    );
};

export default Questionnaire;
