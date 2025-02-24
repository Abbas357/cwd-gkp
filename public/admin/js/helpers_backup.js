function showMessage(t,o="success",e={}){Swal.fire({position:"top-end",icon:o,title:t,showConfirmButton:e.showConfirmButton||!1,timer:e.timer||3e3,...e})}async function confirmAction(t="You won't be able to revert this!",o="warning"){return Swal.fire({title:"Are you sure?",text:t,icon:o,showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, do it!",cancelButtonText:"No, cancel"})}async function confirmWithInput({text:t="Please provide your input",inputValidator:o=null,inputType:e="text",inputPlaceholder:a="",confirmButtonText:n="Submit",cancelButtonText:i="Cancel"}={}){t={title:t,input:"textarea"===e?"textarea":e,inputPlaceholder:a,showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:n,cancelButtonText:i};return o&&(t.inputValidator=o),Swal.fire(t)}async function fetchRequest(t,o="GET",e={},a="Operation successful",n="There was an error processing your request"){try{var i,s={"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content"),Accept:"application/json"},l=(e instanceof FormData||(s["Content-Type"]="application/json"),{method:o,headers:s,body:null}),r=("GET"!==o&&(l.body=e instanceof FormData?e:JSON.stringify(e)),await fetch(t,l));if(r.ok)return(i=await r.json()).success?"GET"===o?i.data:(showMessage(i.success||a),!0):(showMessage(i.error||n||"An unexpected error occurred","error"),!1);if(422===r.status)return handleValidationErrors((await r.json()).errors),!1;throw new Error("HTTP error! Status: "+r.status)}catch(t){return showMessage(n||"There was an error processing your request","error"),!1}}function handleValidationErrors(t){$(".form-error").remove(),setButtonLoading($('button[type="submit"]'),!1);for(const e in t){var o=t[e];const a=$(`[name="${e}"]`);o.forEach(t=>{t=`<span class="form-error text-danger">${t}</span>`;a.after(t)})}}function initDataTable(n,t={}){var o={processing:!0,stateSave:!0,autoWidth:!0,serverSide:!0,colReorder:{columns:":not(:first-child, :last-child)"},ajax:{url:t.ajaxUrl||"",error(t,o,e){$(n).removeClass("card-loading"),"timeout"!==o&&"abort"!==o||$(n).DataTable().ajax.reload()}},order:[[t.defaultOrderColumn||"created_at",t.defaultOrderDirection||"desc"]],columns:t.columns||[],language:{searchBuilder:{title:{0:"Conditions",_:"Conditions (%d)"},clearAll:"Clear All Filters",button:`<span class="symbol-container">
                            <i class="bi-funnel"></i>
                            &nbsp; Filter
                        </span>`}},layout:{topStart:{buttons:[{extend:"collection",text:`<span class="symbol-container">
                                <i class="bi-share"></i>
                                &nbsp; Export
                            </span>`,autoClose:!0,buttons:[{extend:"copy",text:`<span class="symbol-container">
                    <i class="bi-copy"></i>
                    &nbsp; Copy
                </span>`,exportOptions:{columns:":visible:not(:last-child)"}},{extend:"csv",text:`<span class="symbol-container">
                    <i class="bi-filetype-csv"></i>
                    &nbsp; CSV
                </span>`,exportOptions:{columns:":visible:not(:last-child)"}},{extend:"excel",text:`<span class="symbol-container">
                    <i class="bi-file-spreadsheet"></i>
                    &nbsp; Excel
                </span>`,exportOptions:{columns:":visible:not(:last-child)"}},{extend:"print",text:`<span class="symbol-container">
                    <i class="bi-printer"></i>
                    &nbsp; Print
                </span>`,autoPrint:!1,exportOptions:{columns:":visible:not(:last-child)"}}]},{extend:"colvis",collectionLayout:"two-column",text:`<span class="symbol-container">
                                <i class="bi-eye"></i>
                                &nbsp; Columns
                            </span>`},{extend:"searchBuilder",config:{depthLimit:3,preDefined:{criteria:[{origData:"id",data:"id"}]}}},{text:`<span class="symbol-container">
                                <i class="bi-arrow-clockwise"></i>
                                &nbsp; Reset
                            </span>`,action:function(t,o,e,a){confirmAction("Resetting will clear all saved settings").then(t=>{t.isConfirmed&&(o.state.clear(),localStorage.removeItem(n.replace("#","")),window.location.reload())})}},...t.customButton?[t.customButton]:[]]},top1Start:{pageLength:{menu:t.pageLengthMenu||[[5,10,25,50,100,500,-1],[5,10,25,50,100,500,"All"]]}},topEnd:{search:{placeholder:t.searchPlaceholder||"Type search here..."}}},columnDefs:t.columnDefs||[],preDrawCallback(){$(n).addClass("card-loading")},drawCallback(){$(n).removeClass("card-loading")}},o=($.fn.dataTable.ext.errMode="throw",$.extend(!0,{},o,t));return $(n).DataTable(o)}function hashTabsNavigator(t){let{table:o,dataTableUrl:e,tabToHashMap:a,hashToParamsMap:n,defaultHash:i}=t;function s(t){t=(t=(t=t)&&Object.entries(t).filter(([,t])=>void 0!==t).flatMap(([o,t])=>Array.isArray(t)?t.map(t=>encodeURIComponent(o)+"[]="+encodeURIComponent(t)):encodeURIComponent(o)+"="+encodeURIComponent(t)).join("&"))?"?"+t:"",t=e+t;o.ajax.url(t).load()}$(".nav-tabs-table a").on("click",function(){var t=$(this).attr("href");window.location.hash=t});var t=window.location.hash||i;s(n[t]||{}),t=t,$('.nav-tabs-table a[href="'+t+'"]').tab("show"),$(".tab-pane-table").removeClass("active show"),$(t).addClass("active show"),Object.keys(a).forEach(function(o){$(o).on("click",function(){var t=a[o];s(n[t]||{})})})}function setButtonLoading(t,o=!0,e="Please wait..."){var a,n;t&&(t=$(t)).length&&(a=t.closest("form"),n=t.val()||t.html(),o?(a.length&&a.addClass("disabled-form"),t.data("original-text",n),document.documentElement.classList.add("card-loading"),t.is("button")?t.html(`
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                <span role="status">${e}</span>
            `):t.is("input")&&t.val(e),t.prop("disabled",!0)):(a.length&&a.removeClass("disabled-form"),document.documentElement.classList.remove("card-loading"),t.is("button")?t.html(t.data("original-text")):t.is("input")&&t.val(t.data("original-text")),t.prop("disabled",!1)))}function resizableTable(t,o={}){o=Object.assign({},{liveDrag:!0,resizeMode:"overflow",postbackSafe:!0,useLocalStorage:!0,gripInnerHtml:"<div class='grip'></div>",draggingClass:"dragging"},o);$(t).colResizable(o)}function uniqId(o){var e="abcdefghijklmnopqrstuvwxyz0123456789";let a="";for(let t=0;t<o;t++){var n=Math.floor(Math.random()*e.length);a+=e[n]}return a}function imageCropper(options){var defaults={fileInput:"#image",inputLabelPreview:"#image-label-preview",aspectRatio:1,viewMode:2,imageType:"image/jpeg",quality:.7,onComplete:null},uniqueId=(options=$.extend({},defaults,options),uniqId(6)),modalId="#crop-modal-"+uniqueId,cropBoxImageId="#cropbox-image-"+uniqueId,cropButtonId="#apply-crop-"+uniqueId,aspectRatioSelectId="#aspect-ratio-select",actionsContainerId="#action-buttons-"+uniqueId,$fileInput=($("body").append(generateModalHtml(uniqueId)),$(options.fileInput)),$inputLabelPreview=$(options.inputLabelPreview),$cropBoxImage=$(cropBoxImageId),$cropModal=$(modalId),$aspectRatioSelect=$(aspectRatioSelectId),$cropButton=$(cropButtonId),$actionsContainer=$(actionsContainerId),cropper;function loadActionButtons($container){var buttonsHTML=`
        <select id="aspect-ratio-select" class="select-aspect-ratio form-control">
            <option value="">Choose Size</option>
            <option value="1 / 1">1:1 (Square)</option>
            <option value="16 / 9">16:9 (Widescreen)</option>
            <option value="9 / 16">9:16 (Vertical)</option>
            <option value="21 / 9">21:9 (Ultra-wide)</option>
            <option value="4 / 3">4:3 (Old TV)</option>
            <option value="3 / 2">3:2 (DSLR)</option>
            <option value="1 / 1.294">1:1.294 (Letter)</option>
            <option value="1 / 1.6471">1:1.6471 (Legal)</option>
            <option value="NaN">Free (Whatever you want)</option>
        </select>
        <button type="button" class="btn-mode-move btn btn-light btn-sm" data-method="setDragMode" data-option="move" title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
                <span class="text-xs bi-arrows-move"></span>
            </span>
        </button>
        <button type="button" class="btn-mode-crop btn btn-light btn-sm" data-method="setDragMode" data-option="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
                <span class="text-xs bi-crop"></span>
            </span>
        </button>
        <button type="button" class="btn-zoom-in btn btn-light btn-sm" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                <i class="bi bi-zoom-in"></i>
            </span>
        </button>
        <button type="button" class="btn-zoom-out btn btn-light btn-sm" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                <i class="bi bi-zoom-out"></i>
            </span>
        </button>
        <button type="button" class="btn-arrow-left btn btn-light btn-sm" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
                <span class="text-xs bi-arrow-left"></span>
            </span>
        </button>
        <button type="button" class="btn-arrow-right btn btn-light btn-sm" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
                <span class="text-xs bi-arrow-right"></span>
            </span>
        </button>
        <button type="button" class="btn-arrow-up btn btn-light btn-sm" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
                <span class="text-xs bi-arrow-up"></span>
            </span>
        </button>
        <button type="button" class="btn-arrow-down btn btn-light btn-sm" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
                <span class="text-xs bi-arrow-down"></span>
            </span>
        </button>
        <button type="button" class="btn-flip-vr btn btn-light btn-sm" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
                <i class="bi-vr"></i>
            </span>
        </button>
        <button type="button" class="btn-flip-hr btn btn-light btn-sm" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
                <i class="bi-hr"></i>
            </span>
        </button>
        <button type="button" class="btn-add-crop btn btn-light btn-sm" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.crop()">
                <span class="text-xs bi-check-lg"></span>
            </span>
        </button>
        <button type="button" class="btn-remove-crop btn btn-light btn-sm" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.clear()">
                <i class="bi-x"></i>
            </span>
        </button>
        <button type="button" class="btn-lock btn btn-light btn-sm" data-method="disable" title="Disable">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
                <span class="text-xs bi-lock"></span>
            </span>
        </button>
        <button type="button" class="btn-unlock btn btn-light btn-sm" data-method="enable" title="Enable">
            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
                <span class="text-xs bi-unlock"></span>
            </span>
        </button>
    `;$container.html(buttonsHTML),$container.find("#aspect-ratio-select").on("change",function(){var aspectRatio=eval($(this).val());cropper&&cropper.setAspectRatio(aspectRatio)})}function generateModalHtml(t){return`
        <div class="modal modal fade" id="crop-modal-${t}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="cropbox-image-${t}" style="display:block; max-height:300px; max-width:100%">
                        </div>
                        <div id="action-buttons-${t}"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-sm" id="apply-crop-${t}">Crop</button>
                    </div>
                </div>
            </div>
        </div>
        `}$fileInput.on("change",function(t){var o,e,a,t=t.target.files;0!==t.length&&t[0].type.startsWith("image/")?(o=function(t){$cropBoxImage.attr("src",t),$cropModal.modal({backdrop:"static",keyboard:!1}),$cropModal.modal("show")},t&&0<t.length&&(a=t[0],URL?o(URL.createObjectURL(a)):FileReader&&((e=new FileReader).onload=function(t){o(e.result)},e.readAsDataURL(a))),$cropButton.data("input",this),$cropButton.data("preview",$inputLabelPreview)):options.onComplete(t[0],this)}),$cropModal.on("click",function(t){$(t.target).is($cropModal)&&($cropModal.addClass("shake"),setTimeout(function(){$cropModal.removeClass("shake")},500))}),$cropModal.on("shown.bs.modal",function(){var t=parseFloat($aspectRatioSelect.val())||options.aspectRatio;cropper=new Cropper($cropBoxImage[0],{aspectRatio:t,viewMode:options.viewMode,ready:function(){$actionsContainer&&loadActionButtons($actionsContainer)}})}).on("hidden.bs.modal",function(){cropper&&(cropper.destroy(),cropper=null)}),$cropButton.on("click",function(){var t,e;$cropModal.modal("hide"),cropper&&(t=cropper.getCroppedCanvas(),$(this).data("preview").attr("src",t.toDataURL(options.imageType,options.quality)),e=$(this).data("input"),t.toBlob(function(t){var t=new File([t],`cropped-${uniqId(6)}.jpg`,{type:options.imageType}),o=("function"==typeof options.onComplete&&options.onComplete(t,e),new DataTransfer);o.items.add(t),e.files=o.files},options.imageType,options.quality))}),$actionsContainer.on("click",function(t){var o=t.target;if(cropper){for(;o!==this&&!o.getAttribute("data-method");)o=o.parentNode;o===this||o.disabled||-1<o.className.indexOf("disabled")||(t={method:o.getAttribute("data-method"),option:o.getAttribute("data-option"),secondOption:o.getAttribute("data-second-option")}).method&&(cropper[t.method](t.option,t.secondOption),"scaleX"!==t.method&&"scaleY"!==t.method||o.setAttribute("data-option",-t.option))}})}function pushStateModal({title:r="Title",fetchUrl:c,btnSelector:d,loadingSpinner:p="loading-spinner",actionButtonName:u,modalSize:b="md",modalType:m,includeForm:h=!1,formAction:g,modalHeight:v="70vh"}){return new Promise(t=>{const e=m??d.replace(/^[.#]/,"").split("-")[0],a="modal-"+e,n="detail-"+e;var o=u&&u.replace(/\s+/g,"-").toLowerCase()+"-"+e,i=h?`<form id="form-${e}" method="POST" enctype="multipart/form-data">`:"",i=`
        <div class="modal fade" id="${a}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-${b} modal-dialog-centered modal-dialog-scrollable">
                
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${r}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    ${i}
                    <div class="modal-body" style="${h&&"height:"+v}">
                        <div class="${p} text-center mt-2">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="${n} p-1"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Closse">Cancel</button>
                        ${u?`<button type="submit" id="${o}" class="btn btn-primary px-3">${u}</button>`:""}    
                    </div>
                    ${h?"</form>":""}
                </div>
                
            </div>
        </div>`;async function s(t){var o=c.replace(":id",t),t=(h&&$("#form-"+e).attr("action",g.replace(":id",t)),$("#"+a).modal("show"),$(`#${a} .`+p).show(),$(`#${a} .`+n).hide(),await fetchRequest(o)),o=t.result;o?($(`#${a} .modal-title`).text(r),$(`#${a} .`+n).html(o)):($(`#${a} .modal-title`).text("Error"),$(`#${a} .`+n).html('<p class="pb-0 pt-3 p-4">Unable to load content.</p>')),$(`#${a} .`+p).hide(),$(`#${a} .`+n).show()}function l(){var t=new URLSearchParams(window.location.search),o=t.get("id"),t=t.get("type");o&&t===e&&s(o)}$("#"+a).length||$("body").append(i),$(document).on("click",d,function(){var t=$(this).data("id"),o=new URL(window.location).pathname+`?id=${t}&type=`+e+window.location.hash;history.pushState(null,null,o),s(t,e)}),$(window).on("popstate",function(){l()}),$("#"+a).on("hidden.bs.modal",function(){var t=new URL(window.location),t=(t.searchParams.delete("id"),t.searchParams.delete("type"),""+t.pathname+t.search+window.location.hash);history.pushState(null,null,t)}),l(),a.length&&t(a)})}document.addEventListener("DOMContentLoaded",t=>{var o=document.querySelectorAll(".needs-validation");Array.prototype.slice.call(o).forEach(function(o){o.addEventListener("submit",function(t){o.checkValidity()?setButtonLoading(o.querySelector('button[type="submit"], input[type="submit"]')):(t.preventDefault(),t.stopPropagation()),o.classList.add("was-validated")},!1)})});