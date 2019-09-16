<template>
  <div class="Home">
    	<div class="Home-Content">
    		<div class="Home-TitleBlock">
    			<div class="Home-Title">Список пользователей</div>
    			<div class="Home-Btn" @click="addUser">Добавить</div>
    		</div>
				<div class="Home-TitleMessage" v-if="successMessage">Данные успешно добавлены!</div>
    		<div class="Home-TitleMessage" v-if="successEdit">Данные успешно изменены!</div>
    		<div class="Home-TitleMessage" v-if="successDelete">Данные успешно удалены!</div>
    		<div class="Home-TitleMessage Home-TitleMessage_Error" v-if="Error">Произошла ошибка!</div>
    		<div class="Home-List">
    			<div class="Home-Item">Картинка</div>
    			<div class="Home-Item">Имя</div>
    			<div class="Home-Item">Email</div>
    			<div class="Home-Item">Телефон</div>
    			<div class="Home-Item">Изменить</div>
    			<div class="Home-Item">Удалить</div>
    		</div>
    		<div class="Home-List Home-List_Info" v-for="user in users">
    			<div class="Home-Item Home-Item_Text"><img class="Home-Img" :src=user.img></div>
    			<div class="Home-Item Home-Item_Text">{{user.username}}</div>
    			<div class="Home-Item Home-Item_Text">{{user.email}}</div>
    			<div class="Home-Item Home-Item_Text">{{user.mobile}}</div>
    			<div class="Home-Item Home-Item_Text">
    				<div class="Home-Btn Home-Btn_Small" @click="addEdit(user)">Изменить</div>
    			</div>
    			<div class="Home-Item Home-Item_Text">
    				<div class="Home-Btn Home-Btn_Small" @click="Delete(user)">Удалить</div>
    			</div>
    		</div>
    	</div>
    	<div class="Home-Popup" v-if="showAdd">
    		<div class="Home-User">
    			<div class="Home-UserTitle">Добавить Пользователя</div>
    			<div class="Home-UserClose" @click="closeUser">
    				<img src="@/assets/images/close.svg" alt="Img">
    			</div>
					<form class="Home-UserForm" @submit.prevent="submitForm">
						<div class="Home-UserInput">
							<input class="Home-Input" 
										 type="text" 
										 placeholder="Ведите имя"
										 v-model="username">
							<div class="Home-Error" v-if="$v.username.$dirty && !$v.username.required">Поле не должно быть пустым</div>
						</div>
						<div class="Home-UserInput">
							<input class="Home-Input" 
										 type="text" 
										 placeholder="Ведите email"
										 v-model="email">
							<div class="Home-Error" v-if="$v.email.$dirty && !$v.email.required">Поле не должно быть пустым</div>
							<div class="Home-Error" v-if="$v.email.$dirty && !$v.email.email">Введите корректный Email</div>
						</div>
						<div class="Home-UserInput">
							<input class="Home-Input Home-Input_Phone" 
										 type="tel" 
										 placeholder="(555) 555-5555"
										 v-model="mobile"
										 v-mask="'(###) ###-####'">
							<div class="Home-Mask">+7</div>
							<div class="Home-Error" v-if="$v.mobile.$dirty && !$v.mobile.required">Поле не должно быть пустым</div>
						</div>
						<input type="file" @change="onFileSelected">
						<button type="submit" class="Home-Btn Home-Btn_Small">Добавить</button>
					</form>
    		</div>
    	</div>
    	<div class="Home-Popup" v-if="showEdit">
    		<div class="Home-User">
    			<div class="Home-UserTitle">Редактировать данные</div>
    			<div class="Home-UserClose" @click="closeEdit">
    				<img src="@/assets/images/close.svg" alt="Img">
    			</div>
					<form class="Home-UserForm" @submit.prevent="submitEdit">
						<div class="Home-UserInput">
							<input class="Home-Input" 
										 type="text" 
										 placeholder="Ведите имя"
										 v-model="clickedUser.username">
						</div>
						<div class="Home-UserInput">
							<input class="Home-Input" 
										 type="text" 
										 placeholder="Ведите email"
										 v-model="clickedUser.email">
						</div>
						<div class="Home-UserInput">
							<input class="Home-Input Home-Input_Phone" 
										 type="tel" 
										 placeholder="(555) 555-5555"
										 v-model="clickedUser.mobile"
										 v-mask="'(###) ###-####'">
							<div class="Home-Mask">+7</div>
						</div>
							<button type="submit" class="Home-Btn Home-Btn_Small">Добавить</button>
					</form>
    		</div>
    	</div>
    	<div class="Home-Popup" v-if="showDelete">
    		<div class="Home-User">
    			<div class="Home-UserTitle">Удалить данные</div>
    			<div class="Home-UserClose" @click="closeDelete">
    				<img src="@/assets/images/close.svg" alt="Img">
    			</div>
    			<div class="Home-Delete">
    				<div class="Home-Btn Home-Btn_Small" @click="submitDelete">Да</div>
    				<div class="Home-Btn Home-Btn_Small" @click="closeDelete">Нет</div>
    			</div>
    		</div>
    	</div>
  </div>
</template>

<style lang="stylus" scoped>
.Home
	&-Content
		max-width 1200px
		margin 0 auto
		padding-top 50px
		position relative
	&-TitleBlock
		display flex
		justify-content space-between
		align-items center
		padding-bottom 10px
		border-bottom 1px solid #000
		margin-bottom 40px
	&-Title
		font-size 24px
	&-Btn
		padding 10px 20px
		background #008B8B
		color #fff
		border-radius 3px
		font-size 18px
		box-sizing border-box
		cursor pointer
		&_Small
			font-size 14px
			padding 0px
			width 100px
			height 35px
			line-height 35px
			margin 0 auto
			margin-top 50px
			border-radius 3px
			color #fff
			text-align center
			border none
	&-List
		display flex
		justify-content space-around
		color #fff
		align-items center
		background #00f
		&_Info
			background #ddd
			color #000
			padding 0px
	&-Item
		width 25%
		text-align center
		border-right 2px solid #fff
		box-sizing border-box
		border-bottom 2px solid #fff
		height 50px
		line-height 50px
		&:last-child
			border-right 0px
		&_Text
			height 150px
	&-Img
		width 100%
		height 100%
	&-Popup
		position fixed
		width 100%
		height 100%
		background rgba(0, 0, 0, 0.5)
		left 0
		top 0
	&-User
		width 400px
		background #fff
		box-sizing border-box
		padding-bottom 5px
		border-radius 2px
		position absolute
		border-radius 2px
		top 50%
		left 50%
		margin-right -50%
		transform translate(-50%, -50%)
		overflow hidden
		min-height 300px
	&-UserTitle
		font-size 18px
		width 100%
		background #00f
		color #fff
		padding 10px 15px
		box-sizing border-box
	&-UserClose
		position absolute
		top 13px
		right 15px
		cursor pointer
		img
			height 15px
	&-UserForm
		padding 20px 15px
		padding-bottom 10px
		text-align center
	&-UserInput
		position relative
	&-Input
		width 100%
		height 35px
		box-sizing border-box
		padding 0px 15px
		border 1px solid #ddd
		border-radius 2px
		margin-bottom 25px
		&_Phone
			padding-left 30px
	&-Error
		color red
		font-size 14px
		position absolute
		top 37px
	&-Delete
		display flex
		width 245px
		margin 0 auto
		padding-top 50px
	&-TitleMessage
		padding 7px
		background #006400
		position absolute
		top 107px
		width 100%
		color #fff
		box-sizing border-box
		&_Error
			background #DC143C
	&-Mask
		position absolute
		top 7px
		left 12px
		font-size 14px

</style>
<script>
import axios from 'axios'
import {email, required, minLength} from 'vuelidate/lib/validators'
import {TheMask} from 'vue-the-mask'

export default {
  username: 'home',
  data: () => ({
  	showAdd: false,
  	showEdit: false,
  	showDelete: false,
  	username: '',
  	email: '',
  	mobile: '',
  	users: [],
  	Error: false,
  	successMessage: false,
		successEdit: false,
		successDelete: false,
  	clickedUser: {},
  	selectedFile: null
  }),
  validations: {
		username: {required},
		email: {email, required},
		mobile: {required}
	},
	components: {
		TheMask
	},
	mounted() {
  	this.getAllUsers()
  },
  methods: {
  	addUser() {
  		this.showAdd = true
  	},
  	closeUser() {
  		this.showAdd = false
  	},
  	closeEdit() {
  		this.showEdit = false
  	},
  	closeDelete() {
  		this.showDelete = false
  	},
  	onFileSelected(event) {
  		this.selectedFile = event.target.files[0]
  	},
  	getAllUsers() {
  		axios 
      .get("http://antongek.beget.tech/info.php?action=read")
      .then(response => {
      	if(response.data.error) {
      		 this.errorMessage = response.data.message
      	} else {
      		this.users = response.data.users
      		console.log(response.data)
      	}
      })
  	},
  	submitForm() {
  		if(this.$v.$invalid){
					this.$v.$touch()
					return
			}
			const formData = this.toFormData({username: this.username, email: this.email, mobile: this.mobile, img: this.selectedFile})

			axios 
      .post("http://antongek.beget.tech/info.php?action=create", formData)
      .then(response => {
      	if(response.data.error) {
      		 this.errorMessage = response.data.message
      	} else {
      		 this.getAllUsers()
      		 this.successMessage = response.data
      		 setInterval(()=>{
      		 	this.successMessage = false
      		 },2000)
      	}
      })
			
			this.username = ''
			this.email = ''
			this.mobile = ''
			this.$v.$reset()
			this.closeUser()
  	},
  	toFormData(obj) {	
			let form_data = new FormData()
		      for ( let key in obj ) {
		          form_data.append(key, obj[key])
		      } 
		      return form_data
		},
		addEdit(user) {
			this.showEdit = true
			this.clickedUser = user
		},
		submitEdit() {

			const formData = this.toFormData(this.clickedUser)

			axios 
      .post("http://antongek.beget.tech/info.php?action=update", formData)
      .then(response => {
      	if(response.data.error) {
      		 this.errorMessage = response.data.message
      	} else {
      		 this.getAllUsers()
      		 this.successEdit = response.data
      		 setInterval(()=>{
      		 	this.successEdit = false
      		 },2000)
      	}
      })
			this.closeEdit()
		},
		Delete(user) {
  		this.showDelete = true
  		this.clickedUser = user
  	},
  	submitDelete() {

			const formData = this.toFormData(this.clickedUser)

			axios 
      .post("http://antongek.beget.tech/info.php?action=delete", formData)
      .then(response => {
      	if(response.data.error) {
      		 this.errorMessage = response.data.message
      	} else {
      		 this.getAllUsers()
      		 this.successDelete = response.data
      		 setInterval(()=>{
      		 	this.successDelete = false
      		 },2000)
      	}
      })
			this.closeDelete()
		},
  }

}
</script>

