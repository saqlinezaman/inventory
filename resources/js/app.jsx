import React from 'react';
import './bootstrap';
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
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
