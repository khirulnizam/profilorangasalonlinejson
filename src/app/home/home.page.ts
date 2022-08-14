import { Component } from '@angular/core';
//additional sqlite
import { FormGroup, FormBuilder } from "@angular/forms";
import { DbService } from './../services/dborang.service';
import { ToastController } from '@ionic/angular';
import { Router } from "@angular/router";

//for inlineDB
import { HttpClient, HttpHeaders} from '@angular/common/http';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {

  constructor(
    private db: DbService,//from dborang.service
    public formBuilder: FormBuilder,
    private toast: ToastController,
    private router: Router,
    private http:HttpClient
	) {
    
  }//end constructor

  mainForm: FormGroup;//hold data from formgroup
  Data:any[] = []//hold resultsets of records

  ngOnInit(){//on screen init
    this.db.dbState().subscribe((res) => {
      if(res){
        //fetch data from database sqlite if there are records
        this.db.fetchOrangs().subscribe(item => {
          this.Data = item
        })
      }
    });
    this.mainForm = this.formBuilder.group({
      nokp: [''],//reset data form
      nama: [''],
      pendapatan: [''],
    })
  }//end ngOnInit

  tambahOrang(){
    //this is function to add new record of the form to the db-sqlite
    if(this.mainForm.value.nokp!=null || this.mainForm.value.nokp!=""){
      this.db.addOrang(
        this.mainForm.value.nokp,
        this.mainForm.value.nama,
        this.mainForm.value.pendapatan
      ).then((res) => {
        this.mainForm.reset();
      })
    }else{
      alert("NoKP tak boleh kosong");
    }
  }//end tambahOrang

  padamOrang(){
    
  }//end padamOrang

  aduandata:any;
  headers:HttpHeaders;
  success:any;
  error:any;
  urlinsert:any="http://khirulnizam.com/training/1nsertorangasal.php";
  simpanOnline(){
    if(this.mainForm.value.nokp!=null || this.mainForm.value.nokp!=""){
      this.aduandata={
        'nokp':this.mainForm.value.nokp,
        'nama':this.mainForm.value.nama,
        'pendapatan':this.mainForm.value.pendapatan,
      };
      //headers
      
      this.headers=new HttpHeaders();
      this.headers.append('ContentType', 'application/json');
      //transmit to server
      this.http.post(this.urlinsert,this.aduandata,{headers:this.headers})
        .subscribe(data=>{
          this.success = data['success'];
          this.error = data['error'];
          //console.log('berjaya');
          console.log(this.success);
          console.log(this.error);
          alert("Data orang asal telah dihantar, terima kasih");
      },error=> {
        //console.log('error');
          console.log(this.success);
          console.log(this.error);
          alert("Maaf simpanan rekod ada masalah");
      });
    }else{
      alert ("Pastikan NOKP diisi");
    }
  }//simpanOnline

}//end export class
