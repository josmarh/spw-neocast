<template>
    <div>
        <page-component-vue title="Users" 
            :class="[usersListCheck == 0 || usersListCheck == 1 || users.data.length < 3 ? 'h-screen bg-gray-100' : '' ]">
            <notification-vue />
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="p-4">
                    <div class="inline-flex rounded-md shadow-sm mb-3" role="group">
                        <button type="button" @click="addUserModal" 
                            class="group relative flex justify-center
                            py-2 px-3 border border-transparent
                            text-sm font-medium text-white
                            bg-indigo-600 hover:bg-indigo-700
                            focus:outline-none"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create User
                        </button>
                    </div>
                    <!-- filters  -->
                    <div class="relative z-0 xl:float-right">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
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
                            v-model="filter.email"
                            class="block pl-10 py-2 px-0 xl:w-full sm:w-full
                            text-sm text-gray-900 bg-transparent
                            border-0 border-b-2 border-gray-300
                            appearance-none dark:text-white dark:border-gray-600
                            dark:focus:border-blue-500 focus:outline-none 
                            focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" "/>
                        <label
                            for="name-search"
                            class="absolute pl-10 text-sm text-gray-500 dark:text-gray-400
                            duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                            origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                            peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                            peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                            peer-focus:-translate-y-6 "
                            >Search by email
                        </label>
                    </div>
                </div>
                <div v-if="usersListCheck == 2">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4"></th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Role
                                </th>
                                <!-- <th scope="col" class="px-6 py-3">
                                    Created By
                                </th> -->
                                <th scope="col" class="px-6 py-3">
                                    Date Created
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" 
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{user.name}}
                                </th>
                                <td class="px-6 py-4">
                                    {{user.email}}
                                </td>
                                <td class="px-6 py-4">
                                    {{user.role}}
                                </td>
                                <!-- <td class="px-6 py-4">
                                    {{user.created_by.name}}
                                </td> -->
                                <td class="px-6 py-4">
                                    {{formatDate(user.created_at)}}
                                </td>
                                <td class="px-6 py-4">
                                    {{user.active == 1 ? 'Active' : 'Blocked'}}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex">
                                        <!-- edit -->
                                        <div class="tooltip-delete">
                                            <button type="button" @click="updateUserModal(user)"
                                                class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                                focus:outline-none focus:ring-gray-100 
                                                font-medium text-sm px-5 py-2.5 text-center 
                                                inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                                <span class="tooltiptext">Edit</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" 
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- block -->
                                        <div class="tooltip-delete">
                                            <button type="button" @click="blockUserModal(user)"
                                                class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                                focus:outline-none focus:ring-gray-100 
                                                font-medium text-sm px-5 py-2.5 text-center 
                                                inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                                <span class="tooltiptext">Block</span>
                                                <span v-if="user.active == 1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                </span>
                                                <span v-else>
                                                    <span class="tooltiptext">Unblock</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                        <!-- delete -->
                                        <div class="tooltip-delete">
                                            <button type="button" @click="deleteUserModal(user)"
                                                class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                                focus:outline-none focus:ring-gray-100 
                                                font-medium text-sm px-5 py-2.5 text-center 
                                                inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                                <span class="tooltiptext">Delete</span>
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
                            <a v-for="(link, i) of users.meta.links" 
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
                                    i === users.meta.links.length - 1 ? 'rounded-r-md' : '',
                                ]"
                                v-html="link.label">
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            <div v-if="usersListCheck == 1" class="flex justify-center py-20">
                <!-- spinner state -->
                <svg role="status" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
            </div>
            <div v-if="usersListCheck == 3">
                <div class="flex justify-center items-center">
                    <div class="p-4 xl:w-[55rem] text-center sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="text-2xl text-gray-900 dark:text-white">No user available</h5>
                    <div class="justify-center items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                        <img src="../../assets/no_content.png" class="xl:w-82 xl:h-82" />
                    </div>
                    </div>
                </div>
            </div>
            <!-- user creation modal -->
            <TransitionRoot as="template" :show="openCreateUser">
                <Dialog as="div" class="relative z-10" @close="openCreateUser = false">
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
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-2 sm:ml-4 sm:text-left">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Add New User </DialogTitle>
                                </div>
                            </div>
                            <div class="mt-6">
                                <form @submit.prevent="addUser">
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
                                            >Full name
                                        </label>
                                    </div>
                                    <div class="relative z-0 mt-6">
                                        <input
                                            type="email"
                                            id="email"
                                            v-model="model.email"
                                            class="block py-2 px-0 xl:w-full w-full
                                            text-sm text-gray-900 bg-transparent
                                            border-0 border-b-2 border-gray-300
                                            appearance-none dark:text-white dark:border-gray-600
                                            dark:focus:border-blue-500 focus:outline-none 
                                            focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " required/>
                                        <label
                                            for="email"
                                            class="absolute text-sm text-gray-500 dark:text-gray-400
                                            duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                                            origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                            peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                            peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                            peer-focus:-translate-y-6 "
                                            >Email
                                        </label>
                                    </div>
                                    <div class="relative z-0 mt-6">
                                        <input
                                            type="password"
                                            id="password"
                                            v-model="model.password"
                                            class="block py-2 px-0 xl:w-full w-full
                                            text-sm text-gray-900 bg-transparent
                                            border-0 border-b-2 border-gray-300
                                            appearance-none dark:text-white dark:border-gray-600
                                            dark:focus:border-blue-500 focus:outline-none 
                                            focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " required/>
                                        <div class="flex absolute inset-y-0 right-0 items-center pr-3  cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" @click="showPassword('password')"
                                                class="h-5 w-6 text-gray-600 dark:text-gray-400 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                        <label
                                            for="password"
                                            class="absolute text-sm text-gray-500 dark:text-gray-400
                                            duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                                            origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                            peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                            peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                            peer-focus:-translate-y-6 "
                                            >Password
                                        </label>
                                    </div>
                                    <div class="relative z-0 mt-6">
                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            v-model="model.password_confirmation"
                                            class="block py-2 px-0 xl:w-full w-full
                                            text-sm text-gray-900 bg-transparent
                                            border-0 border-b-2 border-gray-300
                                            appearance-none dark:text-white dark:border-gray-600
                                            dark:focus:border-blue-500 focus:outline-none 
                                            focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " required/>
                                        <div class="flex absolute inset-y-0 right-0 items-center pr-3  cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" @click="showPassword('password_confirmation')"
                                                class="h-5 w-6 text-gray-600 dark:text-gray-400 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                        <label
                                            for="password_confirmation"
                                            class="absolute text-sm text-gray-500 dark:text-gray-400
                                            duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                                            origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                            peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                            peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                            peer-focus:-translate-y-6 "
                                            >Confirm Password
                                        </label>
                                    </div>
                                    <!-- roles -->
                                    <div class="mt-6">
                                        <label for="select_role" class="sr-only">Select Role</label>
                                        <select
                                            v-model="model.role"
                                            id="select_role"
                                            class="block py-2 px-0 w-full text-sm text-gray-500
                                                bg-transparent border-0 border-b-2 border-gray-300
                                                appearance-none dark:text-gray-400 dark:border-gray-600
                                                focus:outline-none focus:ring-0 focus:border-gray-200
                                                peer" required>
                                            <option selected disabled hidden value="">Select Role</option>
                                            <option v-for="role in roles.data"
                                                :key="role.id"
                                                :value="role.name">
                                                {{role.name}}
                                            </option>
                                        </select>
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
                                            @click="openCreateUser = false" ref="cancelButtonRef">Cancel
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
            <!-- update user -->
            <TransitionRoot as="template" :show="openUpdateUser">
                <Dialog as="div" class="relative z-10" @close="openUpdateUser = false">
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
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-2 sm:ml-4 sm:text-left">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> 
                                        Update - {{model.name}} 
                                    </DialogTitle>
                                </div>
                            </div>
                            <div class="mt-6">
                                <form @submit.prevent="updateUser">
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
                                            >Full name
                                        </label>
                                    </div>
                                    <div class="relative z-0 mt-6">
                                        <input
                                            type="email"
                                            id="email"
                                            v-model="model.email"
                                            class="block py-2 px-0 xl:w-full w-full
                                            text-sm text-gray-900 bg-transparent
                                            border-0 border-b-2 border-gray-300
                                            appearance-none dark:text-white dark:border-gray-600
                                            dark:focus:border-blue-500 focus:outline-none 
                                            focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " required/>
                                        <label
                                            for="email"
                                            class="absolute text-sm text-gray-500 dark:text-gray-400
                                            duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                                            origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                            peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                            peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                            peer-focus:-translate-y-6 "
                                            >Email
                                        </label>
                                    </div>
                                    <div class="relative z-0 mt-6">
                                        <input
                                            type="password"
                                            id="password"
                                            v-model="model.password"
                                            class="block py-2 px-0 xl:w-full w-full
                                            text-sm text-gray-900 bg-transparent
                                            border-0 border-b-2 border-gray-300
                                            appearance-none dark:text-white dark:border-gray-600
                                            dark:focus:border-blue-500 focus:outline-none 
                                            focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="flex absolute inset-y-0 right-0 items-center pr-3  cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" @click="showPassword('password')"
                                                class="h-5 w-6 text-gray-600 dark:text-gray-400 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                        <label
                                            for="password"
                                            class="absolute text-sm text-gray-500 dark:text-gray-400
                                            duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                                            origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                            peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                            peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                            peer-focus:-translate-y-6 "
                                            >Password
                                        </label>
                                    </div>
                                    <div class="relative z-0 mt-6">
                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            v-model="model.password_confirmation"
                                            class="block py-2 px-0 xl:w-full w-full
                                            text-sm text-gray-900 bg-transparent
                                            border-0 border-b-2 border-gray-300
                                            appearance-none dark:text-white dark:border-gray-600
                                            dark:focus:border-blue-500 focus:outline-none 
                                            focus:ring-0 focus:border-blue-600 peer"
                                            placeholder=" " />
                                        <div class="flex absolute inset-y-0 right-0 items-center pr-3  cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" @click="showPassword('password_confirmation')"
                                                class="h-5 w-6 text-gray-600 dark:text-gray-400 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                        <label
                                            for="password_confirmation"
                                            class="absolute text-sm text-gray-500 dark:text-gray-400
                                            duration-300 transform -translate-y-6 scale-75 top-3 -z-10
                                            origin-[0] peer-focus:left-0 peer-focus:text-blue-600
                                            peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                                            peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                            peer-focus:-translate-y-6 "
                                            >Confirm Password
                                        </label>
                                    </div>
                                    <!-- update roles -->
                                    <div class="mt-6">
                                        <label for="select_role" class="sr-only">Select Role</label>
                                        <select
                                            v-model="model.role"
                                            id="select_role"
                                            class="block py-2 px-0 w-full text-sm text-gray-500
                                                bg-transparent border-0 border-b-2 border-gray-300
                                                appearance-none dark:text-gray-400 dark:border-gray-600
                                                focus:outline-none focus:ring-0 focus:border-gray-200
                                                peer">
                                            <option 
                                                v-for="role in roles.data"
                                                :key="role.id"
                                                :value="role.name">{{role.name}}
                                            </option>
                                        </select>
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
                                            @click="openUpdateUser = false" ref="cancelButtonRef">Cancel
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
            <!-- block -->
            <TransitionRoot as="template" :show="openBlockUser">
                <Dialog as="div" class="relative z-10" @close="openBlockUser = false">
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
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                                                :class="[model.is_active == 1 ? 'bg-red-100' : 'bg-blue-100']">
                                                <ExclamationIcon v-if="model.is_active == 1" class="h-6 w-6 text-red-600" aria-hidden="true" />
                                                
                                                <svg v-if="model.is_active == 0" 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                                        d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <DialogTitle as="h3" v-if="model.is_active == 1" class="text-lg leading-6 font-medium text-gray-900"> Block - {{model.name}} </DialogTitle>
                                                <DialogTitle as="h3" v-else class="text-lg leading-6 font-medium text-gray-900"> Unblock - {{model.name}} </DialogTitle>
                                                <div class="mt-2">
                                                    <p v-if="model.is_active == 1" class="text-sm text-gray-500">
                                                        Are you sure you want to block this user? This user would not be able to login permanently till you unblock.
                                                    </p>
                                                    <p v-else class="text-sm text-gray-500">
                                                        Are you sure you want to unblock this user?
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        
                                        <button type="button" v-if="model.is_active == 1"
                                            class="w-full inline-flex justify-center border 
                                            border-transparent shadow-sm px-4 py-2 bg-red-600 text-base 
                                            font-medium text-white hover:bg-red-700 sm:ml-3 
                                            sm:w-auto sm:text-sm" 
                                            @click="blockUser" :disabled="isDisabled">Block
                                        </button>
                                        <button type="button"  v-else
                                            class="w-full inline-flex justify-center border 
                                            border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base 
                                            font-medium text-white hover:bg-indigo-700 sm:ml-3 
                                            sm:w-auto sm:text-sm" 
                                            @click="blockUser" :disabled="isDisabled">Unblock
                                        </button>
                                        <button type="button" 
                                        class="mt-3 w-full inline-flex justify-center 
                                        border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                        font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 
                                        sm:ml-3 sm:w-auto sm:text-sm" 
                                        @click="openBlockUser = false" ref="cancelButtonRef">Cancel
                                        </button>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
            <!-- delete user -->
            <TransitionRoot as="template" :show="openDeleteUser">
                <Dialog as="div" class="relative z-10" @close="openDeleteUser = false">
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
                                                Are you sure you want to delete this user? All of the user's data will be permanently removed. This action cannot be undone.
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
                                            @click="deleteUser(model.id)" :disabled="isDisabled">Delete
                                        </button>
                                        <button type="button" 
                                        class="mt-3 w-full inline-flex justify-center 
                                        border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                        font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 
                                        sm:ml-3 sm:w-auto sm:text-sm" 
                                        @click="openDeleteUser = false" ref="cancelButtonRef">Cancel
                                        </button>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </page-component-vue>
    </div>
</template>

<script setup>
import PageComponentVue from '../../components/PageComponent.vue';
import NotificationVue from '../../components/Notification.vue';
import store from '../../store';
import moment from 'moment';
import { ref, computed, watch, getCurrentInstance, onMounted } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { ExclamationIcon } from '@heroicons/vue/outline';
import { MenuIcon } from '@heroicons/vue/outline'

const users = computed(() => store.state.users);
const roles = computed(() => store.state.userGuard);
const internalInstance = getCurrentInstance();
const openCreateUser = ref(false);
const openUpdateUser = ref(false);
const openBlockUser = ref(false);
const openDeleteUser = ref(false);
const isDisabled = ref(false)

let usersListCheck = ref(0)
let model = ref({
    id: '',
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
    old_role: '',
    is_active: null,
});
let filter = ref({
    name: '',
    email: ''
});

watch(filter, (newVal, oldVal) => {
    setTimeout(() => {
        searchUser();
    }, 2000);
}, {deep: true});

const getUsers = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    usersListCheck.value = 1;
    store
        .dispatch('getResellerUsers')
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            if(res.data.length)
                usersListCheck.value = 2;
            else
                usersListCheck.value = 3;
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            usersListCheck.value = 3;

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

const addUser = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
    store
        .dispatch('register', {
            name: model['_rawValue'].name,
            email: model['_rawValue'].email,
            password: model['_rawValue'].password,
            password_confirmation: model['_rawValue'].password_confirmation,
            role: model['_rawValue'].role,
        })
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.message);
            isDisabled.value = false;
            openCreateUser.value = false;
            store.dispatch('getResellerUsers');
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isDisabled.value = false;
            openCreateUser.value = false;
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

const getRoles = () => {
    store
        .dispatch('getUserRoles')
        .then((res) => {            
        })
        .catch((err) => {            
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

const searchUser = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    usersListCheck.value = 1;
    store
        .dispatch('searchUsers', filter['_rawValue'].email)
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            if(res.data.length)
                usersListCheck.value = 2;
            else
                usersListCheck.value = 3;
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            usersListCheck.value = 3;

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

const updateUser = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
    store
        .dispatch('updateUser', {
            id: model['_rawValue'].id,
            name: model['_rawValue'].name,
            email: model['_rawValue'].email,
            password: model['_rawValue'].password,
            password_confirmation: model['_rawValue'].password_confirmation,
            new_role: model['_rawValue'].role,
            old_role: model['_rawValue'].old_role,
        })
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.message);
            isDisabled.value = false;
            openUpdateUser.value = false;
            store.dispatch('getResellerUsers');
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isDisabled.value = false;
            openUpdateUser.value = false;
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

const blockUser = () => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
     store
        .dispatch('blockUser', {
            id: model['_rawValue'].id,
            type: model['_rawValue'].is_active == 1 ? 0 : 1,
        })
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.message);
            isDisabled.value = false;
            openBlockUser.value = false;
            store.dispatch('getResellerUsers');
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isDisabled.value = false;
            openBlockUser.value = false;
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

const deleteUser = (id) => {
    internalInstance.appContext.config.globalProperties.$Progress.start();
    isDisabled.value = true;
    store
        .dispatch('deleteUser', id)
        .then((res) => {
            internalInstance.appContext.config.globalProperties.$Progress.decrease(40);
            internalInstance.appContext.config.globalProperties.$Progress.finish();
            store.dispatch("setSuccessNotification", res.message);
            isDisabled.value = false;
            openDeleteUser.value = false;
            store.dispatch('getResellerUsers');
        })
        .catch((err) => {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            isDisabled.value = false;
            openDeleteUser.value = false;
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

const addUserModal = () => {
    model.value.name = '';
    model.value.email = '';
    model.value.password = '';
    model.value.password_confirmation = '';
    openCreateUser.value = true;
}

const updateUserModal = (user) => {
    model.value.id = user.id;
    model.value.name = user.name;
    model.value.email = user.email;
    model.value.password = '';
    model.value.password_confirmation = '';
    model.value.role = user.role;
    model.value.old_role = user.role;
    openUpdateUser.value = true;
}

const blockUserModal = (user) => {
    model.value.id = user.id;
    model.value.name = user.name;
    model.value.is_active = user.active;
    openBlockUser.value = true
}

const deleteUserModal = (user) => {
    model.value.id = user.id;
    model.value.name = user.name;
    openDeleteUser.value = true
}

const formatDate = (value) => {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY')
    }
};

const showPassword = (elm) => {
    let passElm = document.getElementById(elm);
    if(passElm.value !== ''){
        if (passElm.getAttribute('type') == 'password') {
            passElm.setAttribute('type', 'text');
        } else {
            passElm.setAttribute('type', 'password');
        }
    }
}

const getForPage = (ev,link) => {
  ev.preventDefault();
  if(!link.url || link.active) {
    return;
  }
  store.dispatch('getUsers', {url: link.url});
}


onMounted(() => {
    getUsers();
    getRoles();
})
</script>

<style>

</style>