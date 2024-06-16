import axios from 'axios'
import React, { useEffect, useState } from 'react'

const ActiveQuestionnaire = () => {
    // State to hold active questionnaires data
    const [data, setData] = useState()

    // State to hold messages for invitation status
    const [message, setMessage]= useState()

    // Fetch the list of active questionnaires on component mount
    useEffect(()=>{
        axios.get('/api/questionnaires/active').then((res)=>
        // Set the retrieved data to state
        setData(res.data)
        ).catch((err)=> 
        console.log(err)
        )

    },[])
    // Function to send invitation for a specific questionnaire
   const sendInvitation= (id)=>{
    axios.get(`api/questionnaires/${id}/invite`).then((res)=>
        // Set success message on successful invitation
        setMessage("Invitation sent successfully")
        ).catch((err)=> 
            // Set error message on failure
            setMessage("Error occurred")
        )
   }
  return (
    <div>
    <h1>List of Active Questionnaires</h1>
   <h2> {message}</h2>
<ul>
   {
    // Map through the list of active questionnaires and display them
    data?.map((quest, index)=>(
        <li key={index}>
            {quest.title } (Expires: {quest.expiry_date })
            <button
                onClick={()=> sendInvitation(quest.id)}
            >Send Invitation</button>
        </li>
    ))
   }
      
</ul>
      
    </div>
  )
}

export default ActiveQuestionnaire
