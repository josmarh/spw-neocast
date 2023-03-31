
<template>
  <div>
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img class="h-8 " src="/neocast-brand-logo.png" alt="Workflow" />
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <div v-for="item in navigation" :key="item.name">
                  <router-link 
                    v-if="userPermissions.includes(item.permission)"
                    :to="item.to"
                    active-class="bg-gray-900 text-white"
                    :class="[this.$router.name === item.to.name ? '' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 
                    'px-3 py-2 rounded-md text-sm font-medium']">{{ item.name }}
                  </router-link>
                </div>

                <Menu as="div" class="" v-if="userPermissions.includes('view_user_manager')">
                  <div>
                    <MenuButton class="">
                      <span class="sr-only">Open user menu</span>
                      <div 
                        active-class="bg-gray-900 text-white"
                        class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                        >User Manager 

                      </div>
                    </MenuButton>
                  </div>
                  <transition 
                    enter-active-class="transition ease-out duration-100" 
                    enter-from-class="transform opacity-0 scale-95" 
                    enter-to-class="transform opacity-100 scale-100" 
                    leave-active-class="transition ease-in duration-75" 
                    leave-from-class="transform opacity-100 scale-100" 
                    leave-to-class="transform opacity-0 scale-95">
                    <MenuItems 
                      class="origin-top-left absolute mt-2 w-48 
                      rounded-md shadow-lg py-1 bg-white ring-1 ring-black 
                      ring-opacity-5 focus:outline-none z-10"
                    >
                      <MenuItem 
                        v-for="item in userManagerNav" 
                        :key="item.name" v-slot="{ active }">
                          <router-link 
                            :to="item.to" 
                            active-class="bg-gray-100"
                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}
                          </router-link>
                      </MenuItem>
                    </MenuItems>
                  </transition>
                </Menu>

                <router-link v-if="userPermissions.includes('oto8_reseller')"
                  :to="{name: 'Reseller'}"
                  active-class="bg-gray-900 text-white"
                  :class="[this.$router.name === 'Reseller' ? '' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 
                  'px-3 py-2 rounded-md text-sm font-medium']">
                  Reseller
                </router-link>

                <Menu as="div" class="" v-if="userPermissions.includes('bonus_menu')">
                  <div>
                    <MenuButton class="">
                      <span class="sr-only">Open user menu</span>
                      <div
                        active-class="bg-gray-900 text-white"
                        class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                        >Bonus</div>
                    </MenuButton>
                  </div>
                  <transition 
                    enter-active-class="transition ease-out duration-100" 
                    enter-from-class="transform opacity-0 scale-95" 
                    enter-to-class="transform opacity-100 scale-100" 
                    leave-active-class="transition ease-in duration-75" 
                    leave-from-class="transform opacity-100 scale-100" 
                    leave-to-class="transform opacity-0 scale-95">
                    <MenuItems 
                      class="origin-top-left absolute mt-2 w-48 
                      rounded-md shadow-lg py-1 bg-white ring-1 ring-black 
                      ring-opacity-5 focus:outline-none z-10"
                    >
                      <MenuItem 
                        v-for="item in bonusNav" 
                        :key="item.name" v-slot="{ active }">
                          <router-link 
                            v-if="userPermissions.includes(item.permission)"
                            :to="item.to" 
                            active-class="bg-gray-100"
                            :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                            {{ item.name }}
                          </router-link>
                      </MenuItem>
                    </MenuItems>
                  </transition>
                </Menu>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                <!-- <span class="sr-only">View notifications</span>
                <BellIcon class="h-6 w-6" aria-hidden="true" /> -->
              </button>

              <!-- Profile dropdown -->
              <Menu as="div" class="ml-3 relative">
                <div>
                  <MenuButton class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Open user menu</span>
                    <img v-if="user.imageUrl" class="h-8 w-8 rounded-full" :src="user.imageUrl" alt="" />
                    <div v-else>  
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" 
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                  </MenuButton>
                </div>
                <transition 
                  enter-active-class="transition ease-out duration-100" 
                  enter-from-class="transform opacity-0 scale-95" 
                  enter-to-class="transform opacity-100 scale-100" 
                  leave-active-class="transition ease-in duration-75" 
                  leave-from-class="transform opacity-100 scale-100" 
                  leave-to-class="transform opacity-0 scale-95">
                  <MenuItems 
                    class="origin-top-right absolute right-0 mt-2 w-48 
                    rounded-md shadow-lg py-1 bg-white ring-1 ring-black 
                    ring-opacity-5 focus:outline-none z-10"
                  >
                    <MenuItem 
                      v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                      <router-link 
                        :to="item.to" 
                        active-class="bg-gray-100"
                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}
                      </router-link>
                    </MenuItem>
                    <MenuItem>
                      <a href="https://supremewebcustomercare.freshdesk.com" target="_blank"
                          :class="{'bg-gray-100': active}" 
                          class="block py-2 px-4 text-sm text-gray-700 
                          cursor-pointer inline-flex w-full">
                          Support
                      </a>
                  </MenuItem>
                    <MenuItem >
                      <a
                        @click="logout"
                        :class="['block px-4 py-2 text-sm text-gray-700 cursor-pointer']">
                        Sign out
                      </a>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">Open main menu</span>
              <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <!-- mobile navs -->
      <DisclosurePanel class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <div v-for="item in navigation" :key="item.name" >
            <router-link 
              v-if="userPermissions.includes(item.permission)"
              :to="item.to" 
              active-class="bg-gray-900 text-white"
              :class="[ this.$router.name === item.to.name ? '' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 
                'block px-3 py-2 rounded-md text-base font-medium']">{{ item.name }}
            </router-link>
          </div>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <img v-if="user.imageUrl" class="h-8 w-8 rounded-full" :src="user.imageUrl" alt="" />
              <div v-else>  
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" 
                  fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">{{ user.name }}</div>
              <div class="text-sm font-medium leading-none text-gray-400">{{ user.email }}</div>
            </div>
            <button type="button" class="ml-auto bg-gray-800 flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <!-- <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" /> -->
            </button>
          </div>
          <!-- mobile navs -->
          <div class="mt-3 px-2 space-y-1">
            <router-link 
              v-for="item in userNavigation" 
              :key="item.name" as="a" 
              :to="item.to" 
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">{{ item.name }}
            </router-link>
            <router-link v-if="userPermissions.includes('oto8_reseller')"
              :to="{name: 'Reseller'}"
              active-class="bg-gray-900 text-white"
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
              Reseller
            </router-link>
            <DisclosureButton
              @click="logout"
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700"
            >Sign out</DisclosureButton>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>
    
    <router-view></router-view>
    <!-- set progressbar -->
    <vue-progress-bar></vue-progress-bar>

    <div>
      <footer class="bg-gray-800">
        <div class="py-6 px-4 bg-gray-700 md:flex md:items-center md:justify-between">
          <span class="text-sm text-gray-300 sm:text-center">
            &copy; {{new Date().getFullYear()}} <a href="#" class="hover:underline">NeoCast</a>.  All Rights Reserved.
          </span>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import { useStore } from 'vuex'
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import store from '../store'

const userPermissions = computed(() => store.state.user.permissions)
const navigation = [
  { name: 'Dashboard', to: {name: 'Dashboard'}, permission: 'dashboard' },
  { name: 'Channels', to: {name: 'Channels'}, permission: 'channels' },
  { name: 'Videos', to: {name: 'Videos'}, permission: 'videos' },
  { name: 'Uploads', to: {name: 'Uploads'}, permission: 'uploads' },
  { name: 'Live Streams', to: {name: 'LiveStream'}, permission: 'live stream' },
  { name: 'Websites', to: {name: 'Website'}, permission: 'websites' },
  { name: 'Analytics', to: {name: 'Analytics'}, permission: 'analytics' },
]
const userNavigation = [
  { name: 'Your Profile', to: {name: 'Profile'} },
  { name: 'Tutorials', to: {name: 'Tutorials'} },
]
const userManagerNav = [
  { name: 'Users', to: {name: 'Users'} },
  // { name: 'Reseller', to: {name: 'Reseller'} },
  { name: 'Roles', to: {name: 'Roles'} },
  { name: 'Permissions', to: {name: 'Permissions'} },
  { name: 'Articles', to: {name: 'Articles'} },
]

const bonusNav = [
  { name: 'DFY Campaigns', to: {name: 'DfyCampaign'}, permission: 'oto2_dfy_campaigns'},
  { name: 'DFY Traffic', to: {name: 'DfyTraffic'}, permission: 'oto3_dfy_traffic' },
  { name: 'DFY Automation', to: {name: 'DfyAutomation'}, permission: 'oto4_dfy_automation' },
  { name: 'App Bundle', to: {name: 'AppBundle'}, permission: 'oto5_dfy_app_bundle' },
  { name: 'DFY Agency', to: {name: 'DfyAgency'}, permission: 'oto6_dfy_agency' },
  { name: 'Affiliate Coaching', to: {name: 'AffiliateCoach'}, permission: 'oto7_affiliate_coaching' },
]

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    BellIcon,
    MenuIcon,
    XIcon,
  },
  setup() {
    const store = useStore();
    const router = useRouter();

    function logout() {
      store.dispatch('logout')
      .then(() => {
        router.push({
          name: 'Login',
        });
      });
    }

    return {
      user: computed(() => store.state.user.data),
      navigation,
      userNavigation,
      userManagerNav,
      userPermissions,
      bonusNav,
      logout
    }
  },
}
</script>