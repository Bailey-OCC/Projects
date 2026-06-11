import { StrictMode, useState } from 'react'
import { createRoot } from 'react-dom/client'
import ShoppingApp from './ShoppingApp.jsx'
import './index.css'


const root = createRoot(document.getElementById("root"))
root.render(
  <ShoppingApp />
)
