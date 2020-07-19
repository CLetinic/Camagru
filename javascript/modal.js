class Modal extends HTMLElement {
    constructor() {
        super();
        this._modalVisible = false;
        this._modal;
        this.attachShadow({
            mode: 'open'
        });
        this.shadowRoot.innerHTML = `
        <style>
        /* The Modal (background) */
        .modal {
           display: none; /* Hidden by default */
           position: fixed; /* Stay in place */
           z-index: 20; /* Sit on top */
           /* Location of the box */
           left: 0;
           top: 0;
           width: 100%; 
           height: 100%; 
           overflow: auto; /* Enable scroll if needed */
           background-color: #f1eeeec4 /* Black w/ opacity */
           }
           /* Modal Content */
           .modal-content {
           position: relative;
           background-color: white;
           margin: auto;
           padding: 0;
           border: 1px solid #dedbdb;
           width: 35%;
           
           box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
           -webkit-animation-name: animatetop;
           -webkit-animation-duration: 0.4s;
           animation-name: animatetop;
           animation-duration: 0.4s
           
           }
           /* Add Animation */
           
           @-webkit-keyframes animatetop {
           from {top:-300px; opacity:0} 
           to {top:0; opacity:1}
           }
           @keyframes animatetop {
           from {top:-300px; opacity:0}
           to {top:0; opacity:1}
           }
              

        </style>
        <!-- The Modal -->
        <div id="ModalObj" class="modal" style="align-items: center; justify-content: center;">
            <!-- Modal content -->
            
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">                    
                    <slot name="header"></slot>
                    
                    <!-- <h1>User Notification</h1> -->
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <slot name="body"><slot>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
        `
    }

    connectedCallback() {
        this._modal = this.shadowRoot.querySelector(".modal");
    }
    disconnectedCallback() {}
    _showModal() {
        this._modalVisible = true;
        this._modal.style.display = 'flex';
    }
    _hideModal() {
        this._modalVisible = false;
        this._modal.style.display = 'none';
    }
}
customElements.define('popup-modal', Modal);