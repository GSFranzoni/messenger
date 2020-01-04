
const routes = [
    {
        path: '/auth', 
        name: 'Auth', 
        component: () => import('layouts/AuthLayout.vue'),
        children: [
            { path: '', name: 'Auth', component: () => import('pages/Auth.vue') },
        ]
    },
    {
        path: '/',
        name: 'Main',
        component: () => import('layouts/MainLayout.vue'),
        children: [
            { path: '', name: 'Home', component: () => import('pages/Index.vue') },
            { path: 'chat/:to', name: 'Chat', component: () => import('pages/Chat.vue') }
        ]
    }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
    routes.push({
        path: '*',
        component: () => import('pages/Error404.vue')
    })
}

export default routes
