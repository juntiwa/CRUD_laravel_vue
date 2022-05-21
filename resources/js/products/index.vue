<template>
   <div class="container">
      <div class="products__list table  my-3">
         <div class="customers__titlebar dflex justify-content-between align-items-center">
               <div class="customers__titlebar--item">
                  <h1 class="my-1">Products</h1>
               </div>
               <div class="customers__titlebar--item">
                  <button class="btn btn-secondary my-1" @click="newProduct">
                     Add Product
                  </button>
               </div>
         </div>

         <div class="table--heading mt-2 products__list__heading " style="padding-top: 20px;background:#FFF">
               <!-- <p class="table--heading--col1">&#32;</p> -->
               <p class="table--heading--col1">image</p>
               <p class="table--heading--col2">
                  Product
               </p>
               <p class="table--heading--col4">Type</p>
               <p class="table--heading--col3">
                  Inventory
               </p>
               <!-- <p class="table--heading--col5">&#32;</p> -->
               <p class="table--heading--col5">actions</p>
         </div>

         <div class="table--items products__list__item" v-for="item in products" :key="item.id" v-if="products.length > 0">
               <div class="products__list__item--imgWrapper">
                  <img class="products__list__item--img" :src="ourImage(item.photo)"  style="height: 40px;" v-if="item.photo">
               </div>
               <p class="table--items--col2">
                  {{item.name}}
               </p>
               <p class="table--items--col2">
                  {{ item.type }}
               </p>
               <p class="table--items--col3">
                  {{ item.quatity }}
               </p>     
               <div>     
                  <button class="btn-icon btn-icon-success" @click="onEdit(item.id)">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                     </svg>
                  </button>
                  <button class="btn-icon btn-icon-danger" @click="deleteProduct(item.id)">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                     </svg>
                  </button>
               </div>
         </div>
         <div class="table--items products__list__item" v-else >
            <p>Product not found</p>
         </div>
      </div>
   </div>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from "vue-router"

const router = useRouter()

let products = ref([])
onMounted(async () => {
   getProducts()
})
const newProduct = () => {
   router.push('/product/new')
}
const getProducts = async () =>{
   let response =await axios.get("/api/get_all_product")
   products.value = response.data.products
   // console.log('products',response)
}

const ourImage = (img) => {
   return "/upload/" + img
}
const onEdit = (id) => {
   router.push('/product/edit/'+id)
}
const deleteProduct = (id) => {
   Swal.fire({
      title: 'Are you sure?',
      text: "You can't go back",
      icon:"warning",
      showCancelButton:true,
      confirmButtonColor:'#3085d6',
      cancelButtonColor:'#d33',
      confirmButtonText:'Yes, delete it!'
   })
   .then(result => {
      if(result.value){
         axios.get('/api/delete_product/'+id)
         .then(()=>{
            Swal.fire(
               'Delete',
               'Product Delete successfully',
               'success',
            )
            getProducts()
         })
         .catch(()=>{
            Swal.fire("Failed!","There was somthing wrong.", "Warning")
         })
      }
   })
}
</script>