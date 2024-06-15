import axios from "axios"
import { useEffect, useState } from "react"
import { Link } from "react-router-dom"

function Homepage(){
    const [data, setData]= useState()
   useEffect(()=>
    {
        axios.get('/api/welcome').then((res)=>
            setData(res.data)
        ).catch((err)=>
        console.log(err)
        )
    },[]
   )
    return(
        <div>
            {data?.message}
            <br/>
            <br/>
            <Link to={'/create-questionnaire'}>Create a questionnaire</Link>
        </div>
    )
}
export default Homepage