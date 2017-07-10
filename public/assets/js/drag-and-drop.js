window.requestFileSystem  = window.requestFileSystem || window.webkitRequestFileSystem;
// コンストラクタ定義
var dropFileUpload = function(arg) {
    this.dropElm    = document.querySelector(arg.dropElm);
    this.progress   = document.querySelector(arg.progress);
    this.response   = document.querySelector(arg.response);
    this.inputFile  = document.querySelector(arg.inputFile);
    this.uploadFile = document.querySelector(arg.uploadFile);
    this.keepFiles  = null;
};
// メンバ定義
dropFileUpload.prototype = {
    init: function() {
        var self = this;
        this.dropElm.addEventListener('drop', function(e) {
            self.drop.call(self, e);
        }, false);
        this.dropElm.addEventListener('dragover', function(e) {
            self.dragOver.call(self, e);
        }, false);
        this.inputFile.addEventListener('change', function(e) {
            self.keepFiless.call(self, e);
        }, false);
        this.uploadFile.addEventListener('click', function(e) {
            self.upload(self);
        }, false);
    },
    dragOver: function(e) {
        // ブラウザのデフォルトイベントを止める(ファイルを開くとか、画像を開くとか)
        e.preventDefault();
        // ドロップ領域を色変え
        this.dropElm.setAttribute('class', 'over');
    },
    drop: function(e) {
        e.preventDefault();
        // ドロップ領域の色変えをキャンセル
        this.dropElm.setAttribute('class', '');
        this.keepFiles = e.dataTransfer.files;
        this.handleFileSelect.call(this);
    },
    keepFiless: function(e) {
        this.keepFiles = e.target.files;
        this.handleFileSelect.call(this);
    },
    handleFileSelect: function() {
        var self = this;
        if(!self.keepFiles)
            return; self.progress.style.width = '0%';
        self.progress.textContent = '0%';
        var reader = new FileReader();
        reader.addEventListener('error', function(e) {
            self.fileErrorHandler.call(self, e);
        }, false);
        reader.addEventListener('progress', function(e) {
            self.updateProgress.call(self, e);
        }, false);
        reader.onabort = function(e) {
            self.response.innerHTML = 'File read cancelled';
        };
        reader.onload = (function(e) {
            self.uploadFile.disabled = false;
        });
        reader.readAsBinaryString(self.keepFiles[0]);
    },
    updateProgress: function(e) {
        if (e.lengthComputable) {
            var percentLoaded = Math.round((e.loaded / e.total) * 100);
        }
        if (percentLoaded <= 100) {
            this.progress.style.width = percentLoaded + '%';
            this.progress.textContent = percentLoaded + '%';
        }
    },
    fileErrorHandler: function(e) {
        switch(e.target.error.code) {
            case e.target.error.NOT_FOUND_ERR:
                this.response.innerHTML = 'File Not Found!';
                break;
            case e.target.error.NOT_READABLE_ERR:
                this.response.innerHTML = 'File is not readable';
                break;
            case e.target.error.ABORT_ERR:
                break;
            default:
                this.response.innerHTML = 'An error occurred reading this file.';
        }
    },
    upload: function () {
            var self = this;
            var f = new FormData();
            f.append('userfile', self.keepFiles[0]);
            var xhr = new XMLHttpRequest();
            xhr.onload = function(e) {
                var blob = this.response;
                window.URL = window.URL || window.webkitURL;
                var href = window.URL.createObjectURL(blob);
                var link = document.createElement('a');
                link.download = "result.zip";
                link.href = href;
                link.click();
                var state = document.getElementById("state");
                state.innerHTML = "圧縮が完了しました。ダウンロードを開始します";
            };
            xhr.onreadystatechange = function() {
                switch(xhr.readyState) {
                    case 0:
                        console.log("uninitialized");
                        break;
                    case 1:
                        console.log("loading...");
                        $('#loader-bg, #loader').css('display', 'block');
                        break;
                    case 2:
                        console.log("loaded");
                        break;
                    case 3:
                        console.log("interactive ... ");
                        break;
                    case 4:
                        console.log("complete");
                        $('#loader-bg, #loader').css('display', 'none');
                        break;
                }
            };
            xhr.onerror = function(e) {
                console.log("ダウンロードに失敗しました");
                var state = document.getElementById("state");
                state.innerHTML = "ダウンロードに失敗しました";
            };
            xhr.open('POST', '/image/resize_and_crop', true);
            xhr.responseType = 'blob';
            xhr.send(f);
        }
};

function start() {
    var df = new dropFileUpload({ dropElm: '#dropto', progress: '#percent', response: '#response', inputFile: '#input-file', uploadFile: '#upload'});
    df.init();
}