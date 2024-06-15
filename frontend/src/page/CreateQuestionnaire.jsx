import axios from 'axios'
import React, { useEffect, useState } from 'react'
import { useNavigate } from 'react-router-dom'

const CreateQuestionnaire = () => {
    const navigate = useNavigate()
    const [message, setMessage] = useState('')
    const [formData, setFormData] = useState({
        title: "",
        expiry_date: new Date().toISOString().split('T')[0]
    })

    const onchange = (e) => {
        setFormData((prevState) => ({
            ...prevState,
            [e.target.name]: e.target.value,
        }))
    }

    const onFormSubmit = (e) => {
        e.preventDefault()

        axios.post('/api/questionnaires/generate', formData).then(() =>
            setMessage("Form submitted successfully"),
            navigate('/active-questionnaire')
        ).catch((err) => {
            setMessage("Error occurred")
        })
    }

    return (
        <div>
            {message}
            <form onSubmit={onFormSubmit}>
                <label htmlFor="title">Title:</label>
                <input type="text" name="title" id="title" value={formData.title} required onChange={onchange} />
                <br />
                <label htmlFor="expiry_date">Expiry Date:</label>
                <input type="date" name="expiry_date" id="expiry_date" value={formData.expiry_date} required onChange={onchange} />
                <br />
                <button type="submit">Generate</button>
            </form>
        </div>
    )
}

export default CreateQuestionnaire
