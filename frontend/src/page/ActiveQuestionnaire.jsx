import axios from 'axios'
import React, { useEffect, useState } from 'react'

const ActiveQuestionnaire = () => {
    const [data, setData] = useState()
    const [message, setMessage]= useState()
    useEffect(()=>{
        axios.get('/api/questionnaires/active').then((res)=>
        setData(res.data)
        ).catch((err)=> 
        console.log(err)
        )

    },[])
   const sendInvitation= (id)=>{
    axios.get(`api/questionnaires/${id}/invite`).then((res)=>
        setMessage("Invitation sent successfully")
        ).catch((err)=> 
            setMessage("Error occurred")
        )
   }
  return (
    <div>
    <h1>List of Active Questionnaires</h1>
   <h2> {message}</h2>
<ul>
   {
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
