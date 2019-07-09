

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Export PDF</title>
    <style type="text/css">
table {
    border-collapse: collapse;
    width: 100%
}

#laporan td,#acc td,#tdkHadir td{
    border: 1px solid black;
    font-size: 10pt;
}
#user td {
    font-size: 10pt;
}

#laporan th ,#acc th,#user th,#tdkHadir td{
    font-size: 12pt;
}
  </style>

</head>
<body>
  <div style="margin-left: 5%;margin-right: 5%">
    <span >
      <img src="https://i1.wp.com/onecare.id/wp-content/uploads/2017/09/web-logo-1.jpg?fit=100%2C100" alt="" style="width: 9%;float: left;margin-top: -1.5%" >
    </span>
    <span style="font-size: 20pt;word-spacing: 0px"> One Care Indonesia
    <span style="font-size: 8pt;"> <br>&nbsp;&nbsp;Jalan I Gusti Ngurah Rai No. 24 Pondok Kopi, Duren Sawit, Jakarta Timur 13460, Tekp. +62823 111 8001</span>
    </span>
    {{-- <div style="font-size: 40%;margin-top: -4%;margin-left: -12%;">One Heart One Solutin</div> --}}
  </div>
  <hr style="margin-top: -0.15%" >
  <br>
<div style="text-align: center;"><h2><u> Laporan Tanggal {{ substr($laporan->created_at,8,2) }}-{{ substr($laporan->created_at,5,2) }}-{{ substr($laporan->created_at,0,4) }}</u></h2></div>
      <table class="table" border="0" id="user">
            <tr >
              <td width="10%"></td>
              <td width="7%" align="center">Nama</td>
              <td width="3%" align="center">:</td>
              <td width="30%">{{ $user->nama }}</td>          
              <td width="15%"></td>
              <td width="7%" align="center">Wilayah</td>
              <td width="3%" align="center">:</td>
              <td width="25%">{{ $user->wilayah }}</td>
            </tr>          
            <tr >
              <td width="10%"></td>
              <td width="7%" align="center">Status</td>
              <td width="3%" align="center">:</td>
              <td width="30%">
                  @if ($user->status == 'super_admin')
                      Super Admin
                  @elseif ($user->status == 'ft_admin')
                      FT Admin
                  @elseif ($user->status == 'ft_sponsorship')
                      FT Sponsorship
                  @elseif ($user->status == 'ft_kacab')
                      FT Kepala Cabang                        
                  @elseif ($user->status == 'manajer')
                      Manajer                        
                  @elseif ($user->status == 'direktur')
                      Direktur                        
                  @endif 
              </td>          
              <td width="15%"></td>
              <td width="7%" align="center">Cabang</td>
              <td width="3%" align="center">:</td>
              <td width="25%">{{ $cabang->nama }}</td>
            </tr>                             
     
      </table>
      <br>
    @if ($laporan->kehadiran != 'hadir')
            <table class="table" id="tdkHadir">
            <tr >
              <td align="center">
                <br>
                Karyawan dengan nama <b><u>{{ $user->nama }}</u></b> pada tanggal : <b><u>{{ substr($laporan->created_at,8,2) }}-{{ substr($laporan->created_at,5,2) }}-{{ substr($laporan->created_at,0,4) }}</u></b> tidak bisa <b>hadir</b> karena <b><u>{{ $laporan->kehadiran }}</u></b>
                <br>
                </td>
            </tr>                                      
     
      </table>
    @else
 

      <table border="1" id="laporan">
        <thead>
          <tr>
            <th width="3%" align="center" >No.</th>
            <th width="27%">Kegiatan</th>
            <th width="40%">Hasil</th>
            <th width="30%">Keterangan</th>
          </tr>
        </thead>
        <tbody>
        @php
          $i = 1;
        @endphp
      {{--  --}}
          <tr style="background-color: #F0EFEF">
            <td >&nbsp;</td>
            <td colspan="3" align="left" ><b> Formula Pagi </b></td>
          </tr>
          @foreach ($form_pagi as $form)
            @php
              $nama = $form->slug;
              $ket_nama = 'ket_'.$form->slug;
            @endphp
            @if (substr($form->nama,0,10) != 'keterangan' && $laporan->$nama != null )
                                   
                <tr >
                    <td align="center" >{{$i++}}.</td>
                    <td  >&nbsp;{{ $form->nama }}</td>
                    <td  >&nbsp;
                        @if ($form->tipe == 'file')
                             <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAAXVBMVEX///8AAACrq6unp6dXV1dTU1M2Njbv7+97e3v5+flpaWljY2MvLy+3t7fX19ddXV3MzMzp6enOzs5wcHAUFBS9vb0PDw8bGxsxMTFlZWV6enqhoaGbm5spKSkLCwso8iaQAAAB+klEQVR4nO3b63KCMBAFYBBRuQoq1trW93/MTkOnM9gg2d1Dmbbn/E6y3xAyYiBRxIyn7hJ5qgxVvTjFqmy2iPJZrquOErQbfX2EIDPVBwgM1x8iqPtRyqSV9kwxgsKNsVespxRzDdz6KzXrOYXMQj8DiaarA9ysgs71F8//F2C9MwoS113VtQdERoEdYBQAADYBAmASQAAWAQZgEIAAegEKoBbAAFoBDqAUAAE6ARKgEkABGgEWoBCAAXIBGiAWWAFP6X2Ez0hWwHg2Yc+Z8wHibm5AMQFYzQ1olgZETb4eyQ8BxkMAAQQQQAABBBBAAAFGwPUcC3PeIQGv0vIfeQEC1hrAHgi4agDDObABtqW8fjn8M24DRFm3Eqa7+ytuBNhDAAEEEEAAAQQYAU3x7SXARIoGCZjahPZmKLABprbhvcn/EkAzBbcDEPDgPcBY8mH9X78MCSCAAAIIIICArLKeM7AB2jf/U8+jQLfpFt+oXHyrdvHN6mi38HY9IAQQQAABBAgAlWurOuYzntYNWgW1PQiwwekvax3UNnO/fKqjXuNjujefp8DW+sNuo/X3bsh8uqVLPwfxRX7cz582+XzzGzYDEeDAoz/HYHJ2maN+4Ifd/UWbQbARTajl2K8/R+k9XT8rDz77csqD77+BoZJ+NOBPpar+b/IObmYbqPETRmQAAAAASUVORK5CYII=" alt="" style="width:3%">  
                             <span >file{{ $nama }}</span> &nbsp;
                        @else
                          {{ $laporan->$nama }}
                        @endif
                    </td>                                  
                    <td  >&nbsp; 
                       @if ($laporan->$ket_nama == null)
                         -
                        @else
                          {{ $laporan->$ket_nama }}
                        @endif
                    </td>
               </tr> 
               
              @endif
          @endforeach 
      {{--  --}}
          <tr style="background-color: #F0EFEF">
            <td >&nbsp;</td>
            <td colspan="3" align="left" ><b> Formula Inti </b></td>
          </tr>
          @foreach ($form_inti as $form)
            @php
              $nama = $form->slug;
              $ket_nama = 'ket_'.$form->slug;
            @endphp
            @if (substr($form->nama,0,10) != 'keterangan' && $laporan->$nama != null )
                                   
                <tr >
                    <td align="center" >{{$i++}}.</td>
                    <td  >&nbsp;{{ $form->nama }}</td>
                    <td  >&nbsp;
                        @if ($form->tipe == 'file')
                             <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAAXVBMVEX///8AAACrq6unp6dXV1dTU1M2Njbv7+97e3v5+flpaWljY2MvLy+3t7fX19ddXV3MzMzp6enOzs5wcHAUFBS9vb0PDw8bGxsxMTFlZWV6enqhoaGbm5spKSkLCwso8iaQAAAB+klEQVR4nO3b63KCMBAFYBBRuQoq1trW93/MTkOnM9gg2d1Dmbbn/E6y3xAyYiBRxIyn7hJ5qgxVvTjFqmy2iPJZrquOErQbfX2EIDPVBwgM1x8iqPtRyqSV9kwxgsKNsVespxRzDdz6KzXrOYXMQj8DiaarA9ysgs71F8//F2C9MwoS113VtQdERoEdYBQAADYBAmASQAAWAQZgEIAAegEKoBbAAFoBDqAUAAE6ARKgEkABGgEWoBCAAXIBGiAWWAFP6X2Ez0hWwHg2Yc+Z8wHibm5AMQFYzQ1olgZETb4eyQ8BxkMAAQQQQAABBBBAAAFGwPUcC3PeIQGv0vIfeQEC1hrAHgi4agDDObABtqW8fjn8M24DRFm3Eqa7+ytuBNhDAAEEEEAAAQQYAU3x7SXARIoGCZjahPZmKLABprbhvcn/EkAzBbcDEPDgPcBY8mH9X78MCSCAAAIIIICArLKeM7AB2jf/U8+jQLfpFt+oXHyrdvHN6mi38HY9IAQQQAABBAgAlWurOuYzntYNWgW1PQiwwekvax3UNnO/fKqjXuNjujefp8DW+sNuo/X3bsh8uqVLPwfxRX7cz582+XzzGzYDEeDAoz/HYHJ2maN+4Ifd/UWbQbARTajl2K8/R+k9XT8rDz77csqD77+BoZJ+NOBPpar+b/IObmYbqPETRmQAAAAASUVORK5CYII=" alt="" style="width:3%">  
                             <span >file{{ $nama }}</span> &nbsp;
                        @else
                          {{ $laporan->$nama }}
                        @endif
                    </td>                                  
                    <td  >&nbsp; 
                       @if ($laporan->$ket_nama == null)
                         -
                        @else
                          {{ $laporan->$ket_nama }}
                        @endif
                    </td>
               </tr> 
               
              @endif
          @endforeach 
      {{--  --}}
          <tr style="background-color: #F0EFEF">
            <td >&nbsp;</td>
            <td colspan="3" align="left" ><b> Formula Sore </b></td>
          </tr>
          @foreach ($form_sore as $form)
            @php
              $nama = $form->slug;
              $ket_nama = 'ket_'.$form->slug;
            @endphp
            @if (substr($form->nama,0,10) != 'keterangan' && $laporan->$nama != null )
                                   
                <tr >
                    <td align="center" >{{$i++}}.</td>
                    <td  >&nbsp;{{ $form->nama }}</td>
                    <td  >&nbsp;
                        @if ($form->tipe == 'file')
                             <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAAXVBMVEX///8AAACrq6unp6dXV1dTU1M2Njbv7+97e3v5+flpaWljY2MvLy+3t7fX19ddXV3MzMzp6enOzs5wcHAUFBS9vb0PDw8bGxsxMTFlZWV6enqhoaGbm5spKSkLCwso8iaQAAAB+klEQVR4nO3b63KCMBAFYBBRuQoq1trW93/MTkOnM9gg2d1Dmbbn/E6y3xAyYiBRxIyn7hJ5qgxVvTjFqmy2iPJZrquOErQbfX2EIDPVBwgM1x8iqPtRyqSV9kwxgsKNsVespxRzDdz6KzXrOYXMQj8DiaarA9ysgs71F8//F2C9MwoS113VtQdERoEdYBQAADYBAmASQAAWAQZgEIAAegEKoBbAAFoBDqAUAAE6ARKgEkABGgEWoBCAAXIBGiAWWAFP6X2Ez0hWwHg2Yc+Z8wHibm5AMQFYzQ1olgZETb4eyQ8BxkMAAQQQQAABBBBAAAFGwPUcC3PeIQGv0vIfeQEC1hrAHgi4agDDObABtqW8fjn8M24DRFm3Eqa7+ytuBNhDAAEEEEAAAQQYAU3x7SXARIoGCZjahPZmKLABprbhvcn/EkAzBbcDEPDgPcBY8mH9X78MCSCAAAIIIICArLKeM7AB2jf/U8+jQLfpFt+oXHyrdvHN6mi38HY9IAQQQAABBAgAlWurOuYzntYNWgW1PQiwwekvax3UNnO/fKqjXuNjujefp8DW+sNuo/X3bsh8uqVLPwfxRX7cz582+XzzGzYDEeDAoz/HYHJ2maN+4Ifd/UWbQbARTajl2K8/R+k9XT8rDz77csqD77+BoZJ+NOBPpar+b/IObmYbqPETRmQAAAAASUVORK5CYII=" alt="" style="width:3%">  
                             <span >file{{ $nama }}</span> &nbsp;
                        @else
                          {{ $laporan->$nama }}
                        @endif
                    </td>                                  
                    <td  >&nbsp; 
                       @if ($laporan->$ket_nama == null)
                         -
                        @else
                          {{ $laporan->$ket_nama }}
                        @endif
                    </td>
               </tr> 
               
              @endif
          @endforeach
        </tbody>
      </table>
  @endif
  <br>
  <div align="center">

    @if ($user->status == 'ft_admin' || $user->status == 'ft_sponsorship' )
       <table class="table" border="1" id="acc" style="width: 100%">
          <tr >
            <th colspan="3" align="center">  Persetujuan Laporan</th>
          </tr>         
          <tr >
              <td rowspan="3" align="center">
                @if ($laporan->acc_ft_kacab == 'disetujui')
                  <img src="https://pbs.twimg.com/profile_images/858257259788328960/EGf1lr1d_400x400.jpg" alt="" style="width: 9%;" >
                @else
                  <br><br><br>
                @endif
              </td>            
              <td rowspan="3" align="center">
                @if ($laporan->acc_manajer == 'disetujui')
                  <img src="https://pbs.twimg.com/profile_images/858257259788328960/EGf1lr1d_400x400.jpg" alt="" style="width: 9%;" >
                @else
                  <br><br><br>
                @endif
              </td>            
              <td rowspan="3" align="center">
                @if ($laporan->acc_direktur == 'disetujui')
                  <img src="https://pbs.twimg.com/profile_images/858257259788328960/EGf1lr1d_400x400.jpg" alt="" style="width: 9%;" >
                @else
                  <br><br><br>
                @endif
              </td>
          </tr>    

          <tr >          </tr>      

          <tr >         </tr>     

          <tr align="center">
            <td width="33%">Kepala Cabang</td>
            <td width="33%" align="center">Manajer</td>
            <td width="33%" align="center">Direktur</td>
          </tr>          
        </table>
    @elseif($user->status == 'ft_kacab')
           <table class="table" border="1" id="acc" style="width: 100%">
          <tr >
            <th colspan="2" align="center">  Persetujuan Laporan</th>
          </tr>         
          <tr >          
              <td rowspan="3" align="center">
                @if ($laporan->acc_manajer == 'disetujui')
                  <img src="https://pbs.twimg.com/profile_images/858257259788328960/EGf1lr1d_400x400.jpg" alt="" style="width: 9%;" >
                @else
                  <br><br><br>
                @endif
              </td>            
              <td rowspan="3" align="center">
                @if ($laporan->acc_direktur == 'disetujui')
                  <img src="https://pbs.twimg.com/profile_images/858257259788328960/EGf1lr1d_400x400.jpg" alt="" style="width: 9%;" >
                @else
                  <br><br><br>
                @endif
              </td>
          </tr>    

          <tr >          </tr>      

          <tr >         </tr>     

          <tr align="center">
            <td width="33%" align="center">Manajer</td>
            <td width="33%" align="center">Direktur</td>
          </tr>          
        </table>
    @elseif($user->status == 'manajer')
               <table class="table" border="1" id="acc" style="width: 100%">
          <tr >
            <th colspan="1" align="center">  Persetujuan Laporan</th>
          </tr>         
          <tr >                 
              <td rowspan="3" align="center">
                @if ($laporan->acc_direktur == 'disetujui')
                  <img src="https://pbs.twimg.com/profile_images/858257259788328960/EGf1lr1d_400x400.jpg" alt="" style="width: 9%;" >
                @else
                  <br><br><br>
                @endif
              </td>
          </tr>    

          <tr >          </tr>      

          <tr >         </tr>     

          <tr align="center">
            <td width="33%" align="center">Direktur</td>
          </tr>          
        </table>
    @endif

</div>
</body>
</html>