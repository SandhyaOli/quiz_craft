import axios from "axios"
import { useEffect, useState } from "react"
import { Link } from "react-router-dom"

function Homepage(){
    // State to hold the data fetched from the API
    const [data, setData]= useState()

   // useEffect to fetch data when the component mounts
   useEffect(()=>
    {
        axios.get('/api/welcome')
        .then((res)=>setData(res.data)) // Set the fetched data to state
        .catch((err)=>console.log(err)) // Log any error that occurs during the request
    },[]
   )
    return(
        <div>
            {/* Display the message from the fetched data if it exists */}
            {data?.message}
            <br/>
            <br/>
            {/* Link to navigate to the create questionnaire page */}
            <Link to={'/create-questionnaire'}>Create a questionnaire</Link>
        </div>
    )
}
export default Homepage