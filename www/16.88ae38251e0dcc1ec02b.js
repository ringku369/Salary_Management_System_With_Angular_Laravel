(window.webpackJsonp=window.webpackJsonp||[]).push([[16],{Ls0K:function(e,t,n){"use strict";n.r(t),n.d(t,"AdminProfileModule",(function(){return k}));var r=n("ofXK"),i=n("tyNb"),a=(n("QVta"),n("PdH4")),l=n.n(a),o=n("fXoL"),d=n("5eHb"),s=n("JqCM"),m=n("lGQG"),c=n("2QD9"),p=n("yj+E"),u=n("Qe8B"),f=n("1kSV"),g=n("/n7v"),h=n("+Ai/"),b=n("3Pt+"),v=n("lTK2");function S(e,t){if(1&e&&(o["\u0275\u0275elementStart"](0,"div",38),o["\u0275\u0275elementStart"](1,"button",39),o["\u0275\u0275text"](2,"\xd7"),o["\u0275\u0275elementEnd"](),o["\u0275\u0275text"](3),o["\u0275\u0275elementEnd"]()),2&e){const e=t.$implicit,n=o["\u0275\u0275nextContext"]();o["\u0275\u0275property"]("hidden",!n.success),o["\u0275\u0275advance"](3),o["\u0275\u0275textInterpolate1"](" ",e," ")}}function E(e,t){if(1&e&&(o["\u0275\u0275elementStart"](0,"div",40),o["\u0275\u0275elementStart"](1,"button",39),o["\u0275\u0275text"](2,"\xd7"),o["\u0275\u0275elementEnd"](),o["\u0275\u0275text"](3),o["\u0275\u0275elementEnd"]()),2&e){const e=t.$implicit,n=o["\u0275\u0275nextContext"]();o["\u0275\u0275property"]("hidden",!n.errors),o["\u0275\u0275advance"](3),o["\u0275\u0275textInterpolate1"](" ",e," ")}}function y(e,t){if(1&e&&(o["\u0275\u0275elementStart"](0,"div",38),o["\u0275\u0275elementStart"](1,"button",39),o["\u0275\u0275text"](2,"\xd7"),o["\u0275\u0275elementEnd"](),o["\u0275\u0275text"](3),o["\u0275\u0275elementEnd"]()),2&e){const e=t.$implicit,n=o["\u0275\u0275nextContext"]();o["\u0275\u0275property"]("hidden",!n.success),o["\u0275\u0275advance"](3),o["\u0275\u0275textInterpolate1"](" ",e," ")}}function M(e,t){if(1&e&&(o["\u0275\u0275elementStart"](0,"div",40),o["\u0275\u0275elementStart"](1,"button",39),o["\u0275\u0275text"](2,"\xd7"),o["\u0275\u0275elementEnd"](),o["\u0275\u0275text"](3),o["\u0275\u0275elementEnd"]()),2&e){const e=t.$implicit,n=o["\u0275\u0275nextContext"]();o["\u0275\u0275property"]("hidden",!n.errors),o["\u0275\u0275advance"](3),o["\u0275\u0275textInterpolate1"](" ",e," ")}}const x=new Date,C=[{path:"",component:(()=>{class e{constructor(e,t,n,r,i,a,l,o,d){this.router=e,this.toastr=t,this.spinner=n,this.authservice=r,this.authtoken=i,this.authstatus=a,this.adminUserService=l,this.parserFormatter=o,this.calendar=d,this.success=[],this.errors=[],this.form={id:null,name:null,email:null,username:null,contact:null,profession:null,district:null,address:null,gender:"",bank:"0",bank_id:null},this.modelDisabled={year:x.getFullYear(),month:x.getMonth()+1,day:x.getDate()},this.users=[],this.banks=[],this.spinner.show()}emptyMessage(){this.errors=[],this.success=[]}successMsg(e){for(let t=0;t<e.length;t++)this.toastr.success(e[t])}errorMsg(e){for(let t=0;t<e.length;t++)this.toastr.error(e[t])}selectToday(){this.fdate={year:x.getFullYear(),month:x.getMonth()+1,day:x.getDate()}}ngOnInit(){this.getSelfProfile(),this.spinner.hide(),this.selectToday(),this.getBank()}cloneOptions(e){return e.map(e=>({value:e.value,label:e.label}))}getBank(){this.adminUserService.getBankForDD().subscribe(e=>{this.banks=this.cloneOptions(e),this.spinner.hide()},e=>{this.errorMsg(e.error)})}getSelfProfile(){this.adminUserService.getSelfProfile().subscribe(e=>{this.form=e,this.form.bank=e.bank_id.toString(),null==this.form.gender&&(this.form.gender="")},e=>{this.errorMsg(e.error)})}confirmAlert(){l.a.fire({title:"Are you sure?",text:"Once deleted, you will not be able to recover this imaginary file!",showCloseButton:!0,showCancelButton:!0}).then(e=>{e.dismiss?l.a.fire("","Your imaginary file is safe!","error"):l.a.fire("","Poof! Your imaginary file has been deleted!","success")})}onSubmit(){this.submitForm()}submitForm(){this.spinner.show(),this.adminUserService.putSelfProfile(this.form).subscribe(e=>{this.successMsg(e),this.getSelfProfile(),this.spinner.hide()},e=>{this.spinner.hide(),this.errorMsg(e.error)})}updateForm(){this.spinner.show(),this.adminUserService.putSelfEmail(this.form).subscribe(e=>{this.successMsg(e),this.getSelfProfile(),this.spinner.hide()},e=>{this.spinner.hide(),this.errorMsg(e.error)})}}return e.\u0275fac=function(t){return new(t||e)(o["\u0275\u0275directiveInject"](i.f),o["\u0275\u0275directiveInject"](d.c),o["\u0275\u0275directiveInject"](s.c),o["\u0275\u0275directiveInject"](m.a),o["\u0275\u0275directiveInject"](c.a),o["\u0275\u0275directiveInject"](p.a),o["\u0275\u0275directiveInject"](u.a),o["\u0275\u0275directiveInject"](f.e),o["\u0275\u0275directiveInject"](f.c))},e.\u0275cmp=o["\u0275\u0275defineComponent"]({type:e,selectors:[["app-admin-profile"]],decls:80,vars:20,consts:[[1,"row"],[1,"col-sm-12"],["cardTitle","Update Email Address",3,"options"],["type","info","dismiss","true"],[1,"text-center","text-danger","font-weight-bolder"],[1,"m-t-20"],["signupForm1","ngForm"],["class","alert alert-success",3,"hidden",4,"ngFor","ngForOf"],["class","alert alert-warning",3,"hidden",4,"ngFor","ngForOf"],[1,"input-group","input-group-sm","mb-3"],["type","email","name","email","placeholder","Input Email","aria-label","Input Email","aria-describedby","forEmail","required","",1,"form-control",3,"ngModel","ngModelChange"],[1,"input-group-prepend"],["id","forEmail",1,"input-group-text"],[1,"btn","btn-block","btn-sm","btn-primary","mb-4",3,"disabled","click"],["cardTitle","Admin Profile Update",3,"options"],["signupForm","ngForm"],["type","text","name","username","placeholder","Input Username","disabled","","aria-label","Input Username","aria-describedby","forUsername","required","",1,"form-control",3,"ngModel","ngModelChange"],["id","forUsername",1,"input-group-text"],["type","email","name","email","placeholder","Input Email","disabled","","aria-label","Input Email","aria-describedby","forEmail","required","",1,"form-control",3,"ngModel","ngModelChange"],["id","forpos","name","gender","required","",1,"custom-select",3,"ngModel","ngModelChange"],["value",""],["value","Male"],["value","Female"],[1,"input-group-append"],["for","forpos",1,"input-group-text"],["type","text","name","name","placeholder","Input Full Name","aria-label","Input Full Name","aria-describedby","forName","required","",1,"form-control",3,"ngModel","ngModelChange"],["id","forName",1,"input-group-text"],[1,"input-group","input-group-sm","mb-4"],["type","text","name","contact","placeholder","Contact Number","aria-label","Contact Number","aria-describedby","forContact","required","",1,"form-control",3,"ngModel","ngModelChange"],["id","forContact",1,"input-group-text"],["type","text","name","profession","placeholder","Profession","aria-label","Profession","aria-describedby","forProfession","required","",1,"form-control",3,"ngModel","ngModelChange"],["id","forProfession",1,"input-group-text"],["type","text","name","district","placeholder","District","aria-label","District","aria-describedby","forDistrict","required","",1,"form-control",3,"ngModel","ngModelChange"],["id","forDistrict",1,"input-group-text"],["type","text","name","address","placeholder","Address","aria-label","Address","aria-describedby","forAddress","required","",1,"form-control",3,"ngModel","ngModelChange"],["id","forAddress",1,"input-group-text"],["name","bank","id","fordla","aria-describedby","inputGroup-sizing-sm","required","",1,"custom-select",3,"ngClass","options","ngModel","ngModelChange"],["id","inputGroup-sizing-sm","for","fordla",1,"input-group-text"],[1,"alert","alert-success",3,"hidden"],["type","button","data-dismiss","alert","aria-hidden","true",1,"close"],[1,"alert","alert-warning",3,"hidden"]],template:function(e,t){if(1&e&&(o["\u0275\u0275elementStart"](0,"div",0),o["\u0275\u0275element"](1,"ngx-spinner"),o["\u0275\u0275elementStart"](2,"div",1),o["\u0275\u0275elementStart"](3,"app-card",2),o["\u0275\u0275elementStart"](4,"app-alert",3),o["\u0275\u0275elementStart"](5,"span",4),o["\u0275\u0275text"](6," Please update email address because of OTP code is required for fund transferring and OTP code will send to admin mail address "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](7,"form",5,6),o["\u0275\u0275template"](9,S,4,2,"div",7),o["\u0275\u0275template"](10,E,4,2,"div",8),o["\u0275\u0275elementStart"](11,"div",9),o["\u0275\u0275elementStart"](12,"input",10),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.email=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](13,"div",11),o["\u0275\u0275elementStart"](14,"span",12),o["\u0275\u0275text"](15,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](16,"button",13),o["\u0275\u0275listener"]("click",(function(){return t.updateForm()})),o["\u0275\u0275text"](17,"Update Email..."),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](18,"div",1),o["\u0275\u0275elementStart"](19,"app-card",14),o["\u0275\u0275elementStart"](20,"app-alert",3),o["\u0275\u0275elementStart"](21,"span",4),o["\u0275\u0275text"](22," Please update your profile with proper information "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](23,"form",5,15),o["\u0275\u0275template"](25,y,4,2,"div",7),o["\u0275\u0275template"](26,M,4,2,"div",8),o["\u0275\u0275elementStart"](27,"div",9),o["\u0275\u0275elementStart"](28,"input",16),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.username=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](29,"div",11),o["\u0275\u0275elementStart"](30,"span",17),o["\u0275\u0275text"](31,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](32,"div",9),o["\u0275\u0275elementStart"](33,"input",18),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.email=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](34,"div",11),o["\u0275\u0275elementStart"](35,"span",12),o["\u0275\u0275text"](36,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](37,"div",9),o["\u0275\u0275elementStart"](38,"select",19),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.gender=e})),o["\u0275\u0275elementStart"](39,"option",20),o["\u0275\u0275text"](40,"Select Position"),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](41,"option",21),o["\u0275\u0275text"](42,"Male"),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](43,"option",22),o["\u0275\u0275text"](44,"Female"),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](45,"div",23),o["\u0275\u0275elementStart"](46,"label",24),o["\u0275\u0275text"](47,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](48,"div",9),o["\u0275\u0275elementStart"](49,"input",25),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.name=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](50,"div",11),o["\u0275\u0275elementStart"](51,"span",26),o["\u0275\u0275text"](52,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](53,"div",27),o["\u0275\u0275elementStart"](54,"input",28),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.contact=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](55,"div",11),o["\u0275\u0275elementStart"](56,"span",29),o["\u0275\u0275text"](57,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](58,"div",27),o["\u0275\u0275elementStart"](59,"input",30),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.profession=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](60,"div",11),o["\u0275\u0275elementStart"](61,"span",31),o["\u0275\u0275text"](62,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](63,"div",27),o["\u0275\u0275elementStart"](64,"input",32),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.district=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](65,"div",11),o["\u0275\u0275elementStart"](66,"span",33),o["\u0275\u0275text"](67,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](68,"div",27),o["\u0275\u0275elementStart"](69,"input",34),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.address=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](70,"div",11),o["\u0275\u0275elementStart"](71,"span",35),o["\u0275\u0275text"](72,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](73,"div",9),o["\u0275\u0275elementStart"](74,"ng-select",36),o["\u0275\u0275listener"]("ngModelChange",(function(e){return t.form.bank=e})),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](75,"div",11),o["\u0275\u0275elementStart"](76,"label",37),o["\u0275\u0275text"](77,"Required "),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementStart"](78,"button",13),o["\u0275\u0275listener"]("click",(function(){return t.submitForm()})),o["\u0275\u0275text"](79,"Update ..."),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"](),o["\u0275\u0275elementEnd"]()),2&e){const e=o["\u0275\u0275reference"](8),n=o["\u0275\u0275reference"](24);o["\u0275\u0275advance"](3),o["\u0275\u0275property"]("options",!1),o["\u0275\u0275advance"](6),o["\u0275\u0275property"]("ngForOf",t.success),o["\u0275\u0275advance"](1),o["\u0275\u0275property"]("ngForOf",t.errors),o["\u0275\u0275advance"](2),o["\u0275\u0275property"]("ngModel",t.form.email),o["\u0275\u0275advance"](4),o["\u0275\u0275property"]("disabled",!e.valid),o["\u0275\u0275advance"](3),o["\u0275\u0275property"]("options",!1),o["\u0275\u0275advance"](6),o["\u0275\u0275property"]("ngForOf",t.success),o["\u0275\u0275advance"](1),o["\u0275\u0275property"]("ngForOf",t.errors),o["\u0275\u0275advance"](2),o["\u0275\u0275property"]("ngModel",t.form.username),o["\u0275\u0275advance"](5),o["\u0275\u0275property"]("ngModel",t.form.email),o["\u0275\u0275advance"](5),o["\u0275\u0275property"]("ngModel",t.form.gender),o["\u0275\u0275advance"](11),o["\u0275\u0275property"]("ngModel",t.form.name),o["\u0275\u0275advance"](5),o["\u0275\u0275property"]("ngModel",t.form.contact),o["\u0275\u0275advance"](5),o["\u0275\u0275property"]("ngModel",t.form.profession),o["\u0275\u0275advance"](5),o["\u0275\u0275property"]("ngModel",t.form.district),o["\u0275\u0275advance"](5),o["\u0275\u0275property"]("ngModel",t.form.address),o["\u0275\u0275advance"](5),o["\u0275\u0275property"]("ngClass","ng-select")("options",t.banks)("ngModel",t.form.bank),o["\u0275\u0275advance"](4),o["\u0275\u0275property"]("disabled",!n.valid)}},directives:[s.a,g.a,h.a,b.G,b.s,b.t,r.t,b.d,b.C,b.r,b.u,b.D,b.w,b.F,v.a,r.r],styles:["ng-select.ng-select[_ngcontent-%COMP%] > div[_ngcontent-%COMP%]{border-radius:4px;border:none!important;margin-top:-3px!important}"]}),e})()}];let F=(()=>{class e{}return e.\u0275mod=o["\u0275\u0275defineNgModule"]({type:e}),e.\u0275inj=o["\u0275\u0275defineInjector"]({factory:function(t){return new(t||e)},imports:[[i.j.forChild(C)],i.j]}),e})();var I=n("ebz3"),w=n("Kb4U"),q=n("D5FM"),P=n("Mdnn");let k=(()=>{class e{}return e.\u0275mod=o["\u0275\u0275defineNgModule"]({type:e}),e.\u0275inj=o["\u0275\u0275defineInjector"]({factory:function(t){return new(t||e)},imports:[[r.c,F,I.a,q.a,w.a,v.b,b.m,s.b,f.f,P.a]]}),e})()}}]);