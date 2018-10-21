<template>
    <div>
        <textarea name="message" id="btn-input" class="form-control content-group" rows="3" cols="1" placeholder="Type your message here..." v-model="newMessage"  @keyup.enter="sendMessage" @keydown="isTyping" ></textarea>

        <div class="row">
          <div class="col-xs-6">
            <ul class="icons-list icons-list-extended mt-10">
              <li><a href="#" data-popup="tooltip" title="Send photo" data-container="body"><i class="icon-file-picture"></i></a></li>
              <li><a href="#" data-popup="tooltip" title="Send video" data-container="body"><i class="icon-file-video"></i></a></li>
              <li><a href="#" data-popup="tooltip" title="Send file" data-container="body"><i class="icon-file-plus"></i></a></li>
              <li><a href="#" data-popup="tooltip" title="Mark as urgent" data-container="body"><i class="icon-bubble-notification"></i></a></li>
            </ul>
          </div>

          <div class="col-xs-6 text-right">
            <button class="btn bg-teal-400 btn-labeled btn-labeled-right" id="btn-chat" @click="sendMessage"><b><i class="icon-circle-right2"></i></b> Send</button>
          </div>
        </div>
    </div>


</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
              newMessage: ''
          }
        },

        created() {
          let _this = this;

            Echo.private('chat').listenForWhisper('typing', (e) => {
              this.user = e.user;
              this.typing = e.typing;
              this.room_id = e.room_id;

              // remove is typing indicator after 0.9s
              setTimeout(function() {
                _this.typing = false
              }, 900);
            });
        },

        methods: {
          sendMessage() {
            let time = moment().format('YYYY-MM-DD HH:mm:ss');
              this.$emit('messagesent', {
                  user: this.user,
                  room_id: this.room_id,
                  message: this.newMessage,
                  created_at: time
              });

              this.newMessage = '';
          },
          isTyping() {
            let channel = Echo.private('chat');

            setTimeout(function() {
              channel.whisper('typing', {
                user: Laravel.user,
                typing: true
              });
            }, 300);
          },
        }    
    }
</script>
