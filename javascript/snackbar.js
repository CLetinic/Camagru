class Snackbar extends HTMLElement {
    constructor() {
        super();
        this._snackbarVisible = false;
        this._snackbar;
        this.attachShadow({
            mode: 'open'
        });
        this.shadowRoot.innerHTML = `
        <style>
        /* The Snackbar (background) */
        .snackbar {
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
           /* Snackbar Content */
           .snackbar-content {
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
        <!-- The Snackbar -->
        <div id="SnackbarObj" class="snackbar" style="align-items: center; justify-content: center;">
            <!-- Snackbar content -->
            
            <div class="snackbar-content">
                <!-- Snackbar header -->
                <div class="snackbar-header">                    
                    <slot name="header"></slot>
                    
                    <!-- <h1>User Notification</h1> -->
                </div>
                <!-- Snackbar body -->
                <div class="snackbar-body">
                    <slot name="body"><slot>
                </div>
                <!-- Snackbar footer -->
                <div class="snackbar-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
        `
    }

    connectedCallback() {
        this._snackbar = this.shadowRoot.querySelector(".snackbar");
    }
    disconnectedCallback() {}
    _showSnackbar() {
        this._snackbarVisible = true;
        this._snackbar.style.display = 'flex';
    }
    _hideSnackbar() {
        this._snackbarVisible = false;
        this._snackbar.style.display = 'none';
    }
}
customElements.define('popup-snackbar', Snackbar);