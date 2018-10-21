
require('./bootstrap');

window.Vue = require('vue');


Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));

const app = new Vue({
    el: '#app',
		data: {
      messages: [],
      newMessage: '',
      user: '',
      typing: false
    },

    created() {
      this.fetchMessages(); 

      Echo.private('chat')
		  .listen('MessageSent', (e) => {
		    this.messages.push({
		      message: e.message.message,
		      user: e.user,
          created_at: e.message.created_at
		    });
		  });

      let _this = this;

      Echo.private('chat')
      .listenForWhisper('typing', (e) => {
        this.user = e.user;
        this.typing = e.typing;

        // remove is typing indicator after 0.9s
        setTimeout(function() {
          _this.typing = false
        }, 900);
      });
    
    },

    methods: {
      fetchMessages() {
          // var room_id = document.getElementById('room').value;
          var room_id = 1;
          if( room_id != undefined ){
            axios.get('/messages?room='+room_id).then(response => {
                this.messages = response.data;
            });
          }
      },

      addMessage(message) {
          this.messages.push(message);

          axios.post('/messages', message).then(response => {
            // console.log(response.data);
          });
      },
     
    }
});
