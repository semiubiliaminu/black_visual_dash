<template>
    <div>
    <li v-for="item in datas" :key="item.id">{{ item.name }}</li>
    </div>

</template>

<script>

import axios from 'axios';
import { Button } from 'bootstrap';
import { count } from 'd3';
import { method } from 'lodash';
import { D3LineChart } from 'vue-d3-charts';

  export default {

    data: () => ({
        // showMenu: false,
        // showData,

        datas : [],
        
      x: 0,
      y: 0,
        count: 0,
        items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' },
        ]
  }),

  method: {
    increment (){
        // this.item.title= "You click me "
        count++;
    },

    showData(e){
        e.preventDefault()
        this.showMenu = false
        this.x = e.clientX
        this.y = e.clientY
        this.$nextTick(() => {
          this.showMenu = true
        })
    }
    
  },

    onMounted() {
        
          console.log('Application mounted.')
          const id = 2;

          axios.get('chart')
          .then(response => {
            this.datas = response.data
        })
          .catch(error => console.log(error))
          .finally("success");
      },

  }
</script> 