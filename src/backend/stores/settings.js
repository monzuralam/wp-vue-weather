import { defineStore } from "pinia"
import axios from "axios"

export const useSettingStore = defineStore('settings', {
    state: () => {
        return {
            settings: [
                {
                    api_key: "",
                    location: ""
                }
            ]
        }
    },
    getters: {
        fetchSettingData: async () => {
            const response = await axios.get(wpvueAdminLocalizer.apiUrl + "/wvw/v1/settings");
            return response?.data;
        }
    },
    actions: () => {

    }
})