<script lang="ts" setup>

import InstaIcon from "@/Components/Icons/InstaIcon.vue";
import LocationIcon from "@/Components/Icons/LocationIcon.vue";
import PhoneIcon from "@/Components/Icons/PhoneIcon.vue";
import FacebookIcon from "@/Components/Icons/FacebookIcon.vue";
</script>

<template>
    <ul>
        <li>
            <a class="flex items-center" href="tel:+3806677889900">
                <phone-icon class="mr-3"/>
                +38 (066) 77-88-9900</a>
        </li>
        <li class="flex items-center">
            <location-icon class="mr-3"/>
            Анкара, ул. Вкусной еды, д.7
        </li>
        <li>
            <ul class="flex space-x-6">
                <li>
                    <a class="flex items-center" href="#">
                        <facebook-icon class="mr-3"/>
                        Facebook</a>
                </li>
                <li>
                    <a class="flex items-center" href="#">
                        <insta-icon class="mr-3"/>
                        Instagram</a>
                </li>
            </ul>
        </li>
    </ul>
</template>
