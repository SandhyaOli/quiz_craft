
import { useState } from 'react'
import './App.css'
import { useEffect } from 'react'
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom'
import Homepage from './page/Homepage'
import CreateQuestionnaire from './page/CreateQuestionnaire'
import ActiveQuestionnaire from './page/ActiveQuestionnaire'
import Questionnaire from './page/Questionnaire'

function App() {
  return (
    <>
      <Router>
        <Routes>
          <Route path='/' element={<Homepage />} >
          </Route>
          <Route path='/create-questionnaire' element={<CreateQuestionnaire />} >
          </Route>
          <Route path='/active-questionnaire' element={<ActiveQuestionnaire />} >
          </Route>
          <Route path='/questionnaire/:questionnaireid/student/:studentid' element={<Questionnaire />} >
          </Route>
        </Routes>
      </Router>
    </>
  )
}

export default App
