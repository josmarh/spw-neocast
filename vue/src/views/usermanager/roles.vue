<template>
    <div>
        <div v-if="userPermissions.includes('view_roles')">
            <page-component-vue title="Roles" :class="[ rolesListCheck == 0 || rolesListCheck == 1 || roles.data.length < 3 ? 'h-screen bg-gray-100' : '' ]">
                <notification-vue />
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="p-4">
                        <div class="inline-flex rounded-md shadow-sm mb-3" role="group">
                            <button type="button" @click="addRoleModal" 
                                class="group relative flex justify-center
                                py-2 px-3 border border-transparent
                                text-sm font-medium text-white
                                bg-indigo-600 hover:bg-indigo-700
                                focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create Role
                            </button>
                        </div>
                        <!-- filters  -->
                        <div class="relative z-0 xl:float-right">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg
                                    class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                    </path>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="name-search"
                                v-model="roleName"
                                class="block pl-10 py-2 px-0 xl:w-full sm:w-full md:w-half
                                text-sm text-gray-900 bg-transparent
                                border-0 border-b-2 border-gray-300
                                appearance-none dark:text-white
                                dark:border-gray-600 dark:focus:border-blue-500
                                focus:outline-none focus:ring-0 focus:border-blue-600
                                peer" placeholder=" "/>
                            <label
                                for="name-search"
                                class="absolute pl-10 text-sm text-gray-500
                                    dark:text-gray-400 duration-300 transform
                                    -translate-y-6 scale-75 top-3 -z-10
                                    origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                    peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                    peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                    peer-focus:-translate-y-6">Search by name
                            </label>
                        </div>
                    </div>
                    <!-- table data  -->
                    <div v-if="rolesListCheck == 2">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in roles.data" :key="item.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{item.name}}
                                    </th>
                                    <td class="px-6 py-4">
                                        <div class="flex">
                                            <!-- assign permissions -->
                                            <div class="">
                                                <button type="button" @click="assignPermitModal(item)"
                                                    class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                                    focus:outline-none focus:ring-gray-100 
                                                    font-medium text-sm px-5 py-2.5 text-center 
                                                    inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                                    </svg>
                                                    Assign permissions
                                                </button>
                                            </div>
                                            <!-- edit -->
                                            <div class="">
                                                <button type="button" @click="updateRoleModal(item)"
                                                    class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                                    focus:outline-none focus:ring-gray-100 
                                                    font-medium text-sm px-5 py-2.5 text-center 
                                                    inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <!-- delete -->
                                            <div class="">
                                                <button type="button" @click="deleteRoleModal(item)"
                                                    class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                                    focus:outline-none focus:ring-gray-100 
                                                    font-medium text-sm px-5 py-2.5 text-center 
                                                    inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- pagination -->
                        <div class="flex justify-center mt-5 mb-5">
                            <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                                aria-label="Pagination">
                                <a 
                                    v-for="(link, i) of roles.meta.links" 
                                    :key="i"
                                    :disabled="!link.url"
                                    href="#"
                                    @click="getForPage($event,link)"
                                    aria-current="page"
                                    class="relative inline-flex items-center px-4 py-2 border text-sm
                                    font-medium whitespace-nowrap"
                                    :class="[
                                        link.active 
                                        ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
                                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                        i === 0 ? 'rounded-l-md' : '',
                                        i === roles.meta.links.length - 1 ? 'rounded-r-md' : '',
                                    ]"
                                    v-html="link.label">
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div v-if="rolesListCheck == 1" class="flex justify-center py-20">
                    <!-- spinner state -->
                    <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                </div>
                <!-- no data view -->
                <div v-if="rolesListCheck == 3">
                    <div class="flex justify-center items-center">
                        <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                            <h5 class="text-2xl text-gray-900 dark:text-white">No role available</h5>
                            <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                            <!-- <img src="../../assets/no_channel.png" class="xl:w-82 xl:h-82" /> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- role creation modal -->
                <TransitionRoot as="template" :show="openCreateRole">
                    <Dialog as="div" class="relative z-10" @close="openCreateRole = false">
                    <TransitionChild as="template" 
                        enter="ease-out duration-300" 
                        enter-from="opacity-0" 
                        enter-to="opacity-100" 
                        leave="ease-in duration-200" 
                        leave-from="opacity-100" 
                        leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                    </TransitionChild>

                    <div class="fixed z-10 inset-0 overflow-y-auto">
                        <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                        <TransitionChild as="template" 
                            enter="ease-out duration-300" 
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                            enter-to="opacity-100 translate-y-0 sm:scale-100" 
                            leave="ease-in duration-200" 
                            leave-from="opacity-100 translate-y-0 sm:scale-100" 
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-2 sm:ml-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Add Role </DialogTitle>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <form @submit.prevent="addRole">
                                        <div class="relative z-0">
                                            <input
                                                type="text"
                                                id="name"
                                                v-model="model.name"
                                                class="block py-2 px-0 xl:w-full w-full
                                                text-sm text-gray-900 bg-transparent
                                                border-0 border-b-2 border-gray-300
                                                appearance-none dark:text-white dark:border-gray-600
                                                dark:focus:border-blue-500 focus:outline-none 
                                                focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " required />
                                            <label
                                                for="name"
                                                class="absolute text-sm text-gray-500 dark:text-gray-400
                                                duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                                                origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                                peer-focus:-translate-y-6 "
                                                >Role name
                                            </label>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            
                                            <button type="submit"
                                                class="mt-3 w-full inline-flex justify-center border 
                                                shadow-sm px-6 py-2 bg-indigo-600 hover:bg-indigo-700
                                                text-sm font-medium text-white  
                                                sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                                :disabled="isDisabled">Save
                                            </button>
                                            <button type="button" 
                                                class="mt-3 w-full inline-flex justify-center border 
                                                border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium 
                                                text-gray-700 hover:bg-gray-50  sm:mt-0 sm:ml-3 
                                                sm:w-auto sm:text-sm" 
                                                @click="openCreateRole = false" ref="cancelButtonRef">Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </DialogPanel>
                        </TransitionChild>
                        </div>
                    </div>
                    </Dialog>
                </TransitionRoot>
                <!-- update role -->
                <TransitionRoot as="template" :show="openUpdateRole">
                    <Dialog as="div" class="relative z-10" @close="openUpdateRole = false">
                    <TransitionChild as="template" 
                        enter="ease-out duration-300" 
                        enter-from="opacity-0" 
                        enter-to="opacity-100" 
                        leave="ease-in duration-200" 
                        leave-from="opacity-100" 
                        leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                    </TransitionChild>

                    <div class="fixed z-10 inset-0 overflow-y-auto">
                        <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                        <TransitionChild as="template" 
                            enter="ease-out duration-300" 
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                            enter-to="opacity-100 translate-y-0 sm:scale-100" 
                            leave="ease-in duration-200" 
                            leave-from="opacity-100 translate-y-0 sm:scale-100" 
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-2 sm:ml-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> 
                                            Update - {{model.name}} 
                                        </DialogTitle>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <form @submit.prevent="updateRole">
                                        <input type="hidden" v-model="model.id">
                                        <div class="relative z-0">
                                            <input
                                                type="text"
                                                id="name"
                                                v-model="model.name"
                                                class="block py-2 px-0 xl:w-full w-full
                                                text-sm text-gray-900 bg-transparent
                                                border-0 border-b-2 border-gray-300
                                                appearance-none dark:text-white dark:border-gray-600
                                                dark:focus:border-blue-500 focus:outline-none 
                                                focus:ring-0 focus:border-blue-600 peer"
                                                placeholder=" " required />
                                            <label
                                                for="name"
                                                class="absolute text-sm text-gray-500 dark:text-gray-400
                                                duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                                                origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                                peer-focus:-translate-y-6 "
                                                >Role name
                                            </label>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            
                                            <button type="submit"
                                                class="mt-3 w-full inline-flex justify-center border 
                                                shadow-sm px-6 py-2 bg-indigo-600 hover:bg-indigo-700
                                                text-sm font-medium text-white  
                                                sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                                :disabled="isDisabled">Save
                                            </button>
                                            <button type="button" 
                                                class="mt-3 w-full inline-flex justify-center border 
                                                border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium 
                                                text-gray-700 hover:bg-gray-50  sm:mt-0 sm:ml-3 
                                                sm:w-auto sm:text-sm" 
                                                @click="openUpdateRole = false" ref="cancelButtonRef">Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </DialogPanel>
                        </TransitionChild>
                        </div>
                    </div>
                    </Dialog>
                </TransitionRoot>
                <!-- delete user -->
                <TransitionRoot as="template" :show="openDeleteRole">
                    <Dialog as="div" class="relative z-10" @close="openDeleteRole = false">
                        <TransitionChild as="template" 
                            enter="ease-out duration-300" 
                            enter-from="opacity-0" 
                            enter-to="opacity-100" 
                            leave="ease-in duration-200" 
                            leave-from="opacity-100" 
                            leave-to="opacity-0"
                        >
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                        </TransitionChild>

                        <div class="fixed z-10 inset-0 overflow-y-auto">
                            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                                <TransitionChild as="template" 
                                    enter="ease-out duration-300" 
                                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                    enter-to="opacity-100 translate-y-0 sm:scale-100" 
                                    leave="ease-in duration-200" 
                                    leave-from="opacity-100 translate-y-0 sm:scale-100" 
                                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                >
                                    <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Delete - {{model.name}} </DialogTitle>
                                                <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    Are you sure you want to delete this role? This action cannot be undone.
                                                </p>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            
                                            <button type="button" 
                                                class="w-full inline-flex justify-center border 
                                                border-transparent shadow-sm px-4 py-2 bg-red-600 text-base 
                                                font-medium text-white hover:bg-red-700 sm:ml-3 
                                                sm:w-auto sm:text-sm" 
                                                @click="deleteRole(model.id)" :disabled="isDisabled">Delete
                                            </button>
                                            <button type="button" 
                                                class="mt-3 w-full inline-flex justify-center 
                                                border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                                font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 
                                                sm:ml-3 sm:w-auto sm:text-sm" 
                                                @click="openDeleteRole = false" ref="cancelButtonRef">Cancel
                                            </button>
                                        </div>
                                    </DialogPanel>
                                </TransitionChild>
                            </div>
                        </div>
                    </Dialog>
                </TransitionRoot>
                <!-- assign permissions to role -->
                <TransitionRoot as="template" :show="openPermitRole">
                    <Dialog as="div" class="relative z-10" @close="openPermitRole = false">
                        <TransitionChild as="template" 
                            enter="ease-out duration-300" 
                            enter-from="opacity-0" 
                            enter-to="opacity-100" 
                            leave="ease-in duration-200" 
                            leave-from="opacity-100" 
                            leave-to="opacity-0"
                        >
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                        </TransitionChild>

                        <div class="fixed z-10 inset-0 overflow-y-auto">
                            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                                <TransitionChild as="template" 
                                    enter="ease-out duration-300" 
                                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                    enter-to="opacity-100 translate-y-0 sm:scale-100" 
                                    leave="ease-in duration-200" 
                                    leave-from="opacity-100 translate-y-0 sm:scale-100" 
                                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                >
                                    <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl 
                                        transform transition-all sm:my-8 sm:max-w-2xl w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-0 sm:text-left">
                                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Permissions for {{model.name}} </DialogTitle>
                                                    
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div v-if="permissionsCheck == 1" class="flex justify-center py-20">
                                                    <!-- spinner state -->
                                                    <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                                    </svg>
                                                </div>
                                                <!-- no data view -->
                                                <div v-if="permissionsCheck == 3">
                                                    <div class="flex justify-center items-center">
                                                        <div class="p-4 xl:w-full text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                                                            <h5 class="text-lg text-gray-900 dark:text-white">No permission available</h5>
                                                            <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                                                            <!-- <img src="../../assets/no_channel.png" class="xl:w-82 xl:h-82" /> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="permissionsCheck == 2" class="grid xl:grid-cols-4 xl:gap-3 mt-6">
                                                    <div v-for="permit in rolePermissions" :key="permit.id">
                                                        <div class="flex items-center mb-2">
                                                            <input :id="permit.name" type="checkbox" 
                                                                :value="permit.name"
                                                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded 
                                                                border-gray-300 focus:ring-blue-500 
                                                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600 permit-name"
                                                                :checked="permit.role_id !== null ? true : false">
                                                            <label :for="permit.name" 
                                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{permit.name}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            
                                            <button type="button" v-if="rolePermissions.length"
                                                class="w-full inline-flex justify-center border 
                                                border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base 
                                                font-medium text-white hover:bg-indigo-700 sm:ml-3 
                                                sm:w-auto sm:text-sm"
                                                @click="assignPermissions"
                                                :disabled="isDisabled">Assign
                                            </button>
                                            <button type="button" 
                                            class="mt-3 w-full inline-flex justify-center 
                                            border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                            font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 
                                            sm:ml-3 sm:w-auto sm:text-sm" 
                                            @click="openPermitRole = false" ref="cancelButtonRef">Cancel
                                            </button>
                                            <span class="mr-3">{{modelPermits.message}}</span>
                                        </div>
                                    </DialogPanel>
                                </TransitionChild>
                            </div>
                        </div>
                    </Dialog>
                </TransitionRoot>

            </page-component-vue>
        </div>
        <div v-else class="h-screen bg-gray-200">
            <p class="text-center py-52 text-gray-500 uppercase antialiased 
                font-semibold font-sans text-lg">
                {{auth}}
            </p>
        </div>
    </div>
</template>

<script setup>
import PageComponentVue from '../../components/PageComponent.vue';
import NotificationVue from '../../components/Notification.vue';
import store from '../../store';
import { ref, computed, watch, getCurrentInstance, onMounted } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { ExclamationIcon } from '@heroicons/vue/outline';
import { MenuIcon } from '@heroicons/vue/outline'

const userPermissions = computed(() => store.state.user.permissions);
const roles = computed(() => store.state.userGuard);
const internalInstance = getCurrentInstance();
const openCreateRole = ref(false);
const openUpdateRole = ref(false);
const openDeleteRole = ref(false);
const openPermitRole = ref(false);
const isDisabled = ref(false);
const rolePermissions = ref([]);

let auth = ref('');
let rolesListCheck = ref(0)
let model = {
    id: null,
    name: '',
};
let roleName = ref('');

watch(roleName, (newVal, oldVal) => {
    setTimeout(() => {
        searchRole();
    }, 2000);
});

const getRoles = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    rolesListCheck.value = 1;
    store
        .dispatch('getUserRoles')
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            if(res.data.length)
                rolesListCheck.value = 2;
            else
                rolesListCheck.value = 3;
            
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            rolesListCheck.value = 3;
            
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        auth.value = err.response.data.message;
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                    setTimeout(() => {
                        store.dispatch("setErrorNotification", "");
                    }, 3000);
                }
            }
        })
}

const searchRole = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    rolesListCheck.value = 1;
    store
        .dispatch('getUserRoles', {url: `${import.meta.env.VITE_API_BASE_URI}/api/roles?name=${roleName.value}`})
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            if(res.data.length)
                rolesListCheck.value = 2;
            else
                rolesListCheck.value = 3;
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            rolesListCheck.value = 3;

            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

const addRole = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
    store
        .dispatch('storeRole', {
            name: model.name,
        })
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.message);
            isDisabled.value = false;
            openCreateRole.value = false;
            store.dispatch('getUserRoles');
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isDisabled.value = false;
            openCreateRole.value = false;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

const updateRole = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
    store
        .dispatch('updateRole', {
            id: model.id,
            name: model.name,
        })
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.message);
            isDisabled.value = false;
            openUpdateRole.value = false;
            store.dispatch('getUserRoles');
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isDisabled.value = false;
            openUpdateRole.value = false;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

const deleteRole = (id) => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
    store
        .dispatch('deleteRole', id)
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.message);
            isDisabled.value = false;
            openDeleteRole.value = false;
            store.dispatch('getUserRoles');
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isDisabled.value = false;
            openDeleteRole.value = false;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

let modelPermits = ref({
    assignedPermits: [],
    unAssignedPermits: [],
    message: ''
});
const assignPermissions = () => {
    // add unAssigned permits into it's array
    modelPermits.value.assignedPermits = [];
    modelPermits.value.unAssignedPermits = [];
    let permits = document.getElementsByClassName('permit-name');
    
    for(let p of permits) {
        if(p.checked) {
            modelPermits.value.assignedPermits.push(p.value)
        }else{
            modelPermits.value.unAssignedPermits.push(p.value)
        }
    }

    if(modelPermits.value.assignedPermits.length > 0){
        internalInstance.appContext.config.globalProperties.$Progress.start();
        isDisabled.value = true;
        store
            .dispatch('permissionsAssignRole', {
                permissions: modelPermits['_rawValue'].assignedPermits,
                unpermit: modelPermits['_rawValue'].unAssignedPermits,
                roleId: model.id,
            })
            .then((res) => {
                internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
                internalInstance.appContext.config.globalProperties.$Progress.finish();
                store.dispatch("setSuccessNotification", res.message);
                isDisabled.value = false;
                modelPermits.value.message = res.message;
            })
            .catch((err) => {
                internalInstance.appContext.config.globalProperties.$Progress.fail();
                isDisabled.value = false;
                openPermitRole.value = false;
                if(err.response) {
                    if (err.response.data) {
                        if (err.response.data.hasOwnProperty("message")) {
                            store.dispatch("setErrorNotification", err.response.data.message);
                        } else {
                            store.dispatch("setErrorNotification", err.response.data.error);
                        }
                    }
                }
            })
    }else {
        modelPermits.value.message = 'Please select one or more permission.';
    }
}

const addRoleModal = () => {
    model.name = '';
    openCreateRole.value = true
}

const updateRoleModal = (role) => {
    model.id = role.id;
    model.name = role.name;
    openUpdateRole.value = true;
}

const deleteRoleModal = (role) => {
    model.id = role.id;
    model.name = role.name;
    openDeleteRole.value = true
}

let permissionsCheck = ref(0);
const assignPermitModal = (role) => {
    model.id = role.id;
    model.name = role.name;
    modelPermits.value.message = ''
    openPermitRole.value = true;
    permissionsCheck.value = 1;

    store
        .dispatch('getRolePermission', role.id)
        .then((res) => {
            if(res.data.length) {
                rolePermissions.value = res.data;
                permissionsCheck.value = 2;
            }else{
                permissionsCheck.value = 3;
            }
        })
        .catch((err) => {
            permissionsCheck.value = 3;
            
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message")) {
                        store.dispatch("setErrorNotification", err.response.data.message);
                    } else {
                        store.dispatch("setErrorNotification", err.response.data.error);
                    }
                }
            }
        })
}

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    store.dispatch('getUserRoles', {url: link.url});
}

onMounted(() => {
    getRoles();
})
</script>