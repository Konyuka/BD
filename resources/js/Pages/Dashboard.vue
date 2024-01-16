<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { ref, onMounted, reactive, isRef } from "vue";
import { reverseDate } from "@/Scripts/reverseDate";
import { formatTime } from "@/Scripts/formatTime";
import { router } from '@inertiajs/vue3';

const posts = reactive({
    data: [],
    links: {},
    meta: {}
})
const filter = ref({
    title: null,
    company: null,
    industry: null,
    number: null,
    posted: null,
    expiry: null,
});
const loadMoreIntersect = ref()
const getPosts = (page = 1) => {
    axios.get('/api/tender/listing', { params: { page } })
        .then(response => {
            posts.data = posts.data.concat(response.data.data)
            posts.meta = response.data.meta
        });
}
const limitTitleCount = (inputString, maxCharacters) => {
    if (inputString.length > maxCharacters) {
        return inputString.substring(0, maxCharacters);
    }
    return inputString;
}
const getFilteredPosts = (page = 1) => {
    axios.post(route('filter.listing'), filter.value, { params: { page } })
        .then((response) => {
            posts.data = posts.data.concat(response.data.data)
            posts.meta = response.data.meta
        })
        .catch((err) => {
            console.log(err)
        });
}
const loadMore = (e) => {
    let preloadHeightPx = 340;
    let needsMoreContent = document.documentElement.scrollTop + window.innerHeight >= document.documentElement.offsetHeight - preloadHeightPx;
    let currentPage = posts.meta.current_page
    let lastPage = posts.meta.last_page

    if (needsMoreContent && currentPage < lastPage) {

        if (isRef(filter) && typeof filter.value === 'object') {
            getFilteredPosts(currentPage + 1)
        } else {
            alert();
            getPosts(currentPage + 1)
        }
    } else {
        if (posts.data.length) {
            notificationContent.value.message = 'End of Tenders List'
            notificationContent.value.success = false
            notificationToast.value = true;
        }
    }
}
const loadFilters = () => {
    posts.data = [];
    posts.links = {};
    posts.meta = {};
    getFilteredPosts();
}
const clearFilters = () => {
    filter.value.title = null,
        filter.value.company = null,
        filter.value.industry = null,
        filter.value.number = null,
        filter.value.posted = null,
        filter.value.expiry = null,
        getPosts();
}

const checkDateValidity = (date, expiryDate) => {
    if (date == 'Invalid date') {
        return formatTime(reverseDate(expiryDate));
    } else {
        return date;
    }
}

const downloadDoc = async (tender) => {
    router.post(route('download.tender.file'), {
        link: tender.link,
        tenderId: tender.id,
    }, {
        onSuccess: () => {
            const downloadLink = document.createElement('a');
            downloadLink.href = '/tenderFiles/' + props.tender.id + '.html';
            const combinedSentence = props.tender.tender_brief.split(' ').join('-');
            downloadLink.download = combinedSentence + '.html';
            downloadLink.click();
        }
    })
}

onMounted(() => {
    if (!filter.value == null) {
        getFilteredPosts();
    } else {
        getPosts();
    }
    const observer = new IntersectionObserver(entries => entries.forEach(entry => entry.isIntersecting && loadMore(), {
        rootMargin: "-100px 0px 0px 0px"
    }));
    observer.observe(loadMoreIntersect.value)
})
</script>

<template>
    <MainLayout title="Dashboard">

        <div>
            <div v-if="posts.data.length" v-for="tender in posts.data" :key="tender.id"
                class="grid grid-cols-1 gap-2 mt-5 mx-8">

                <div
                    class="shadow-xl max-w-full px-5 py-3 bg-white border border-primary rounded-lg dark:bg-secondary dark:border-primary">
                    <div class="flex justify-between w-full">
                        <span class="flex">
                            <h5 class="line-clamp-1 mb-2 text-md font-bold tracking-tight text-gray-500 dark:text-white">
                                {{ limitTitleCount(tender.tender_brief, 90) }}</h5>
                        </span>
                        <span>
                            <button @click="downloadDoc(tender)" type="button"
                                class="hover:scale-110 duration-500 ease-in-out rounded bg-primary px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-seco focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2">
                                Download Tender File
                            </button>
                        </span>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400 text-sm my-5">
                        {{ tender.work_detail }}

                    </p>
                    <div class="flex justify-between ">
                        <div class="text-xs font-bold text-white flex gap-5 flex-wrap">
                            <p>Posted Date: <span class="font-semibold italic ml-2 text-green-500">{{
                                formatTime(tender.created_at) }}</span></p>
                            <p>Expiry Date: <span class="font-semibold italic ml-2 text-red-500">{{
                                checkDateValidity(formatTime(tender.expiry), tender.expiry) }}</span></p>
                            <!-- <p>Expiry Date: <span class="font-semibold italic ml-2 text-red-500">{{
                                    formatTime(reverseDate(tender.expiry)) }}</span></p> -->
                            <p>Fund Type: <span class="font-semibold italic ml-2 text-purple-500">{{ tender.funded_by
                            }}</span></p>
                            <p>Tender Number: <span class="font-semibold italic ml-2 text-purple-500">{{ tender.tender_number
                            }}</span></p>
                            <p>Contact Mail: <span class="font-semibold italic ml-2 text-purple-500">{{ tender.email
                            }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <span ref="loadMoreIntersect" />

            <div v-if="!posts.data.length" class="flex flex-col justify-center h-[60vh]">
                <p class="self-center text-3xl font-bold italic tracking-widest text-gray-600">We currently have no tenders
                    available</p>
                <div class="flex justify-center mt-10">
                    <button @click="clearFilters()" type="button"
                        class="hover:scale-110 duration-500 ease-in-out rounded-md bg-seco px-12 py-3 text-md font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Clear Filters
                    </button>
                </div>
            </div>

        </div>




    </MainLayout>
</template>
