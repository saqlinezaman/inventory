import React from 'react';
import './bootstrap';
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // optional, JS components এর জন্য
import '../css/app.css';

//  import NProgress from 'nprogress'

createInertiaApp({
  resolve: name => import(`./Pages/${name}.jsx`),
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />)
  },
})
 router.on('start', () => {
NProgress.start()
 })
 router.on('finish', () =>{
 NProgress.done()
 })
