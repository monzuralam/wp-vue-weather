<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useSettingStore } from "../stores/settings.js";

const settingStore = useSettingStore();

const Setting = ref({
  api_key: "",
  location: "",
});

onMounted(() => {
  const initData = settingStore.fetchSettingData;
  initData.then( (value) => {
    Setting.value.api_key = value.api_key;
    Setting.value.location = value.location;
  })
});

const updateSetting = () => {
  const api_key = Setting?.value?.api_key;
  const location = Setting?.value?.location;

  if (api_key !== "" && api_key.length == 30 && location !== "") {
    console.log(api_key + location);
    axios
      .post(wpvueAdminLocalizer.apiUrl + "/wvw/v1/settings", {
        api_key: api_key,
        location: location,
      })
      .then((response) => {
        if (response?.status == 200) {
          document.getElementById("api_key").classList.remove("error");
        }
      });
  } else {
    document.getElementById("api_key").classList.add("error");
  }
};
</script>

<template>
  <div class="relative">
    <form action="#" method="post" class="form" @submit.prevent="updateSetting">
      <div class="max-w-md">
        <div class="grid grid-cols-1 gap-2">
          <label class="block">
            <span class="text-black dark:text-white font-semibold"
              >API Key</span
            >
            <input
              type="text"
              class="mt-1 block w-full"
              id="api_key"
              name="api_key"
              v-model="Setting.api_key"
              placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
            />
          </label>
          <p>
            Generate API Key form
            <a href="https://www.weatherapi.com/" class="underline"
              >Weather API</a
            >
          </p>
          <label class="block">
            <span class="text-black dark:text-white font-semibold"
              >Location</span
            >
            <input
              type="text"
              class="mt-1 block w-full"
              name="location"
              v-model="Setting.location"
              placeholder="Dhaka"
            />
          </label>
          <div class="block">
            <div class="mt-2">
              <input
                type="submit"
                class="bg-black text-white leading-normal px-2 py-1"
                value="Save"
              />
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped>
.error {
  border: 1px solid red;
}
</style>
