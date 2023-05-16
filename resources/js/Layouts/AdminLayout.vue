<script lang="ts" setup>

import PizzaIcon from "@/Components/Icons/PizzaIcon.vue";
import {onMounted, onUnmounted, ref} from "vue";
import {Link} from "@inertiajs/vue3";
import MenuIcon from "@/Components/Icons/MenuIcon.vue";
import SideNavItem from "@/Components/SideNavItem.vue";
import {IResizeEventTarget} from "@/types/IResizeEventTarget";
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {
    faChartLine,
    faClipboardList,
    faFolder,
    faHelmetSafety,
    faTag,
    faUserGroup
} from "@fortawesome/free-solid-svg-icons";

const isSideNavOpen = ref(false)

const isActionListOpen = ref(false)

const width = ref(window.innerWidth)

const resizeEvent = (ev) => {
    const target = ev.target as IResizeEventTarget
    width.value = window.innerWidth

    if (target.innerWidth < 640) {
        isSideNavOpen.value = false
    }
}

onMounted(() => {
    addEventListener('resize', resizeEvent)
})

onUnmounted(() => {
    removeEventListener('resize', resizeEvent)
})
</script>

<template>
    <div class="font-sans-serif w-full min-h-[100vh]">
        <header class="fixed top-0 right-0 z-30 border-y border-gray-200 bg-white px-3 w-full sm:w-[calc(100%-66px)]">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center sm:ml-2">

                    <div class="block hover:bg-orange-100 rounded-full p-2.5 mr-1 sm:hidden" role="button">
                        <menu-icon class="h-6 w-6 fill-amber-50"/>
                    </div>
                    <Link :href="route('home')" class="flex items-center sm:ml-0.5">
                        <pizza-icon class="w-5 h-5 fill-amber-50"/>
                        <span class="ml-3 md:text-lg whitespace-nowrap text-lg">Куда пицца</span>
                    </Link>
                </div>

                <div class="text-xl font-semibold">Dashboard</div>
                <div class="relative bg-white h-full flex">
                    <button class="flex items-center" @click="isActionListOpen = !isActionListOpen">
                        <img alt="Alex Prover" class="md:w-10 md:h-10 w-8 h-8" src="/images/nice-pizza.png">
                        <span class="ml-2">Alex Prover</span>
                    </button>
                    <transition name="action-list">
                        <div v-if="isActionListOpen"
                             class="absolute right-0 bg-white border border-gray-200 py-2 w-full -z-10 top-16">
                            <ul class="px-2">
                                <li>
                                    <a class="flex flex-col  py-2 text-sm" href="#">Выйти</a>
                                </li>
                            </ul>
                        </div>
                    </transition>
                </div>
            </div>
        </header>

        <!--overlay-->
        <aside :class="{
                'w-[66px]': !isSideNavOpen,
                'w-[240px]': isSideNavOpen,
                }"
               class=" fixed left-0 top-0 z-40 px-0.5 pt-2.5 h-full border border-gray-200 bg-white hidden sm:block">
            <div class="flex items-center ml-2">

                <div class="block hover:bg-orange-100 rounded-full p-2.5  mr-[33px]" role="button"
                     @click="isSideNavOpen = !isSideNavOpen">
                    <menu-icon class="h-6 w-6 fill-amber-50"/>
                </div>
                <Link v-if="isSideNavOpen" :href="route('home')" class="flex items-center">
                    <pizza-icon class="w-5 h-5 fill-amber-50"/>
                    <span class="ml-3 md:text-lg whitespace-nowrap text-lg">Куда пицца</span>
                </Link>
            </div>

            <!--TODO Make a nav with following items: Categories/ Products / Personal / Orders / Dashboard - general statistics  Clients - email notification -->
            <div class="mt-2.5">
                <nav>
                    <a href="#">
                        <SideNavItem :is-side-nav-open="isSideNavOpen" label="Dashboard" short-label="Dash">
                            <template #icon="{classes}">
                                <font-awesome-icon :class="classes" :icon="faChartLine"/>
                            </template>
                        </SideNavItem>

                    </a>

                    <SideNavItem :is-side-nav-open="isSideNavOpen" label="Orders" short-label="Orders">
                        <template #icon="{classes}">
                            <font-awesome-icon :class="classes" :icon="faClipboardList"/>
                        </template>
                    </SideNavItem>

                    <SideNavItem :is-side-nav-open="isSideNavOpen" label="Products" short-label="Prod">
                        <template #icon="{classes}">
                            <font-awesome-icon :class="classes" :icon="faTag"/>
                        </template>
                    </SideNavItem>

                    <SideNavItem :is-side-nav-open="isSideNavOpen" label="Categories" short-label="Categ">
                        <template #icon="{classes}">
                            <font-awesome-icon :class="classes" :icon="faFolder"/>
                        </template>
                    </SideNavItem>

                    <SideNavItem :is-side-nav-open="isSideNavOpen" label="Clients" short-label="Clients">
                        <template #icon="{classes}">
                            <font-awesome-icon :class="classes" :icon="faUserGroup"/>
                        </template>
                    </SideNavItem>

                    <SideNavItem :is-side-nav-open="isSideNavOpen" label="Employees" short-label="Employ">
                        <template #icon="{classes}">
                            <font-awesome-icon :class="classes" :icon="faHelmetSafety"/>
                        </template>
                    </SideNavItem>
                </nav>
            </div>
        </aside>

        <main :class="{
                'w-[calc(100%-66px)]': !isSideNavOpen && width > 640,
                'w-[calc(100%-240px)]': isSideNavOpen && width > 640,
                'w-full': width < 640,
            }" class="absolute top-[66px] min-h-[calc(100vh-66px)] right-0 bg-gray-bg">
            <slot/>
        </main>
    </div>
</template>

<style scoped>
.action-list-enter-active,
.action-list-leave-active {
    transform: translateY(0);
    transition: transform 0.8s ease-in-out;
}

.action-list-enter-from,
.action-list-leave-to {
    transform: translateY(-66px);
}
</style>
