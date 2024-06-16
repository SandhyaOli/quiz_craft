import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

const Questionnaire = () => {
    // Destructuring the URL parameters to get the questionnaire ID and student ID
    const { questionnaireid, studentid } = useParams();

    // State to hold the data fetched from the API
    const [data, setData] = useState(null);

    // State to hold any error or status messages
    const [message, setMessage] = useState('');

    // useEffect to fetch the questionnaire data when the component mounts or the parameters change
    useEffect(() => {
        axios.get(`/api/questionnaires/${questionnaireid}/student/${studentid}`)
            .then((res) => setData(res.data)) // Set the fetched data to state
            .catch((err) => {
                console.error(err); // Log any errors that occur during the request
                setMessage('Error while loading questionnaire.'); // Set an error message
            });
    }, [questionnaireid, studentid]); // Dependencies to re-run the effect if they change

    // Function to handle form submission
    const handleSubmit = async (event) => {
        event.preventDefault(); // Prevent the default form submission behavior
        const formData = new FormData(event.target); // Get the form data
        const answers = {};

        // Process form data to get answers
        formData.forEach((value, key) => {
            if (key.startsWith('answer_')) {
                const questionId = key.replace('answer_', '');
                answers[questionId] = value;
            }
        });

        // Prepare the payload to be sent in the POST request
        const payload = {
            student_id: studentid,
            questionnaire_id: questionnaireid,
            answers: answers
        };

        try {
            // Send the POST request with the answers
            const response = await axios.post('/api/responses/store', payload);
            alert(response.data.message); // Show a success message
        } catch (error) {
            console.error(error); // Log any errors that occur during the request
            alert('An error occurred while submitting your responses.'); // Show an error message
        }
    };

    // If there is an error message, display it
    if (message) {
        return <div>{message}</div>;
    }

    // If data is not yet loaded, show a loading message
    if (!data) {
        return <div>Loading...</div>;
    }

    return (
        <div>
            {/* Display the title of the questionnaire */}
            <h1>{data.questionnaire.title}</h1>
            {/* Form for submitting answers */}
            <form onSubmit={handleSubmit}>
                {/* Hidden inputs to store the student and questionnaire IDs */}
                <input type="hidden" name="student_id" value={studentid} />
                <input type="hidden" name="questionnaire_id" value={questionnaireid} />
                {/* Loop through the questions and render them */}
                {data.questions.map((question, index) => (
                    <div key={index}>
                        <p>{question.question}</p>
                        {/* Loop through the options for each question and render them as radio buttons */}
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
                <br/>
                {/* Submit button for the form */}
                <button type="submit">Submit</button>
            </form>
        </div>
    );
};

export default Questionnaire;
