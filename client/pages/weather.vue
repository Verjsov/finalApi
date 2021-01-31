<template>
    <div class="content">
        <section>
            <b-field label="Airport Code">
                <b-input v-model="code"></b-input>
            </b-field>
            <div class="buttons">
                <b-button @click="$fetch" type="is-primary">Get Weather</b-button>
            </div>
        </section>
        <section>
            <div>

                <div v-if="weatherAiports">
                    <p>{{weatherAiports.code}}</p>
                    <p>{{weatherAiports.city}}</p>
                    <p>{{weatherAiports.temperature}}</p>
                </div>

            </div>
        </section>
    </div>
</template>
<script>
export default {
    data() {
        return {
            code: null,
        
            weatherAiports: []
        }
    },
    async fetch() {
        this.weatherAiports = await this.$http.$get(`http://localhost:8000/api/weather/${this.code}`)
    }
}
</script>