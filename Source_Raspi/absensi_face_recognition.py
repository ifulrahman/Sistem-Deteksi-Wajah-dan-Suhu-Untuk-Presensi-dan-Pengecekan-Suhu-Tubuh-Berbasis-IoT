#for rpi buster
#run_in-terminal : LD_PRELOAD=/usr/lib/arm-linux-gnueabihf/libatomic.so.1.2.0 python3 nameproject.py

import RPi.GPIO as GPIO
import cv2,os
import tkinter
from tkinter import *
import numpy as np
import requests
import json
import time
from Adafruit_AMG88xx import Adafruit_AMG88xx
import pygame

iddev = "1"
KEY = "FaceRec888"

Server = "http://presensiku.xyz/cd"
url_absensi = Server+"/cd/api/absensi"
url_addFaceID = Server+"/cd/api/addfaceid"
url_delFaceID = Server+"/cd/api/delfaceid"
url_confirmFaceID = Server+"/cd/api/confirm"
url_name_user = Server+"/cd/api/listfaceid"

kalibrasi_suhu = 15
suhu_minimal = 35.0

accuracy = 30

GPIO.setwarnings(False)
GPIO.cleanup()


root = Tk()
root.title("Absensi Face Recognition")
root.geometry("480x640")
main = Label(root, text="Absensi Face Recognition", font=("arial", 20, "bold"), fg="steelblue").pack()


def get_ID():
    flag = False
       
    nama = ""
    face_id = ""
    img_name = ""
    
    try:
        addID = requests.post(url_addFaceID, data={"key":KEY, "iddev":iddev}, timeout=2).json()
        #print(json.dumps(addID, indent=4, sort_keys=True))
        if addID['status'] == "ADD":
            nama = addID['nama']
            face_id = addID['face_id']
            img_name = addID['image']
        if addID['status'] == "-":
            print("Tidak ada Face ID baru dari SERVER")
    except requests.exceptions.Timeout as e1:
        print("request to server time out")
    except requests.exceptions.RequestException as e2:
        print("send data capture connection aborted")
        print("check the internet connection")
    
            
    if nama != "" and face_id != "":
        print("Nama "+nama)
        print("Face ID "+face_id)
        cam = cv2.VideoCapture(0)
        detector=cv2.CascadeClassifier('/home/pi/Absensi/Source_Raspi/absensi/include/face.xml')
        font = cv2.FONT_HERSHEY_SIMPLEX
        i=0
        offset=10
        try:
            print("Starting Capture...")
            while True:
                ret, im =cam.read()
                gray=cv2.cvtColor(im,cv2.COLOR_BGR2GRAY)
                faces=detector.detectMultiScale(gray, scaleFactor=1.2, minNeighbors=5, minSize=(200, 200), flags=cv2.CASCADE_SCALE_IMAGE)
                for(x,y,w,h) in faces:
                    i=i+1
                    label = "Capture foto "+nama+" "+str(i)
                    print(label)
                    cv2.imwrite("/home/pi/Absensi/Source_Raspi/absensi/face/face_"+img_name+"-"+face_id +"."+ str(i) + ".jpg", gray[y-offset:y+h+offset,x-offset:x+w+offset])
                    cv2.rectangle(im,(x-50,y-50),(x+w+50,y+h+50),(225,0,0),2)
                    cv2.putText(im,label,(10,400),font,1,(255,255,255),2)
                    cv2.waitKey(200)
                    if i > 5:
                        flag = True
                cv2.imshow('frame capture',im)
                
                if cv2.waitKey(10) & 0xFF==ord('q'):
                    cam.release()
                    cv2.destroyAllWindows()
                    break
            
                if i>=20:
                    cam.release()
                    cv2.destroyAllWindows()
                    break
        except:
            print("error")
            cam.release()
            cv2.destroyAllWindows()

    if flag:
        try:
            send_data_confirm = requests.post(url_confirmFaceID,
                        data={"key":KEY,"iddev":iddev,"confirm_add":face_id}, timeout=2).json()
            print(json.dumps(send_data_confirm, indent=4, sort_keys=True))
        except requests.exceptions.Timeout as e1:
            print("send data capture time out")
        except requests.exceptions.RequestException as e2:
            print("send data capture connection aborted")
            print("check the internet connection")

#########################################

def del_ID():
    nama = ""
    face_id = ""
    img_name = ""
    
    try:
        delID = requests.post(url_delFaceID, data={"key":KEY, "iddev":iddev}, timeout=2).json()
        print(json.dumps(delID, indent=4, sort_keys=True))
        if delID['status'] == "DEL":
            nama = delID['nama']
            face_id = delID['face_id']
            img_name = delID['image']
        if delID['status'] == "-":
            print("Tidak ada Face ID yang di hapus dari SERVER")
    except requests.exceptions.Timeout as e1:
        print("request to server time out")
    except requests.exceptions.RequestException as e2:
        print("send data capture connection aborted")
        print("check the internet connection")
    
    if nama != "" and face_id != "":
        print("Menghapus data")
        print("Nama "+nama)
        print("Face ID "+face_id)

        pathx = "/home/pi/Absensi/Source_Raspi/absensi/face"
        nameFile = "/face_"
        image_paths = [os.path.join(pathx, f) for f in os.listdir(pathx)]
        
        for xi in image_paths:
            #print(xi)
            if xi[:len(pathx)+len(nameFile)+len(img_name)+1+len(face_id)] == pathx+nameFile+img_name+"-"+face_id:
                if os.path.exists(xi):
                    print("menghapus "+xi)
                    os.remove(xi)
                
        try:
            send_del_confirm = requests.post(url_confirmFaceID,
                        data={"key":KEY,"iddev":iddev,"confirm_del":face_id}, timeout=2).json()
            print(json.dumps(send_del_confirm, indent=4, sort_keys=True))
            if send_del_confirm['status'] == "DEL":
                print("Berhasil menghapus data Face ID dari SERVER")
        except requests.exceptions.Timeout as e1:
            print("send data capture time out")
        except requests.exceptions.RequestException as e2:
            print("send data capture connection aborted")
            print("check the internet connection")

#########################################

def train():        #train foto
    from PIL import Image
    
    def get_images_and_labels(path):
        image_paths = [os.path.join(path, f) for f in os.listdir(path)]
        # images will contains face images
        images = []
        # labels will contains the label that is assigned to the image
        labels = []
        for image_path in image_paths:
            # Read the image and convert to grayscale
            image_pil = Image.open(image_path).convert('L')
            # Convert the image format into numpy array
            image = np.array(image_pil, 'uint8')
            # Get the label of the image
            nbr = int(os.path.split(image_path)[1].split("-")[1].split(".")[0])
            #nbr=int(''.join(str(ord(c)) for c in nbr))
            print (nbr)
            # Detect the face in the image
            faces = faceCascade.detectMultiScale(image)
            # If face is detected, append the face to images and the label to labels
            for (x, y, w, h) in faces:
                images.append(image[y: y + h, x: x + w])
                labels.append(nbr)
                cv2.imshow("Adding faces to traning set...", image[y: y + h, x: x + w])
                cv2.waitKey(10)
        # return the images list and labels list
        return images, labels

    recognizer = cv2.face.LBPHFaceRecognizer_create()
    cascadePath = "/home/pi/Absensi/Source_Raspi/absensi/include/face.xml"
    faceCascade = cv2.CascadeClassifier(cascadePath);
    
    try:
        images, labels = get_images_and_labels("/home/pi/Absensi/Source_Raspi/absensi/face")
        cv2.imshow('train',images[0])
        cv2.waitKey(1)
        recognizer.train(images, np.array(labels))
        recognizer.write('/home/pi/Absensi/Source_Raspi/absensi/include/trainer.yml')
        print("Proses Train Face selesai")
        cv2.destroyAllWindows()
    except:
        print("File Image Rusak, hapus beberapa file image yang rusak dan ulangi Proses Train Face")
        cv2.destroyAllWindows()

#########################################

def absensi():          #absensi

    try:
        data_FaceID = requests.post(url_name_user, data={"key":KEY, "iddev":iddev}).json()
        print(json.dumps(data_FaceID, indent=4, sort_keys=True))
        
        id_list = []
        nama_list = []

        for i in data_FaceID['id']:
            print(i)
            id_list.append(i)

        for i in data_FaceID['nama']:
            print(i)
            nama_list.append(i)
            
    except requests.exceptions.Timeout as e1:
        print("requests data Face ID time out")
        return
    except requests.exceptions.RequestException as e2:
        print("requests data Face ID connection aborted, check internet")
        return

    recognizer = cv2.face.LBPHFaceRecognizer_create()
    recognizer.read('/home/pi/Absensi/source_Code/absensi/include/trainer.yml')
    cascadePath = "/home/pi/Absensi/Source_Code/absensi/include/face.xml"
    faceCascade = cv2.CascadeClassifier(cascadePath);
    Id = 0
    face_id = 0

    cam = cv2.VideoCapture(0)
    cam.set(cv2.CAP_PROP_FRAME_WIDTH, 640)
    cam.set(cv2.CAP_PROP_FRAME_HEIGHT, 480)
    font = cv2.FONT_HERSHEY_SIMPLEX
    haveSend = False
    sensor = Adafruit_AMG88xx()
    dataTemp = []
                    #X
    mapAddr = [[ 0, 1, 2, 3, 4, 5, 6, 7],
               [ 8, 9,10,11,12,13,14,15],
               [16,17,18,19,20,21,22,23],
               [24,25,26,27,28,29,30,31],   #Y
               [32,33,34,35,36,37,38,39],
               [40,41,42,43,44,45,46,47],
               [48,49,50,51,52,53,54,55],
               [56,57,58,59,60,61,62,63]]
    #mapAddr(Y,X)
    flagCountTemp = 0
    flagTemp = False
    suhuTubuh = 0.0
    sendDataAbsen = False
    sudahAbsen = ""
    old_id = 0
    count_face = 0
    face_id = 0
    suhuTinggi = False
    while True:
        ret, im = cam.read()
        haveSend = False
        detectFace = False
        if ret == True :
            cv2.putText(im,"Face ID Scanner", (10,50),font,1,(0,255,0), 2)
            #x = 640px, buang sisi kiri 80px, buang sisi kanan 80px
            #y = 480px
            #           start x,y target x , y
            cv2.rectangle(im,(80,0), (560,480), (225,0,0),2)
            nama="Unknown"
            
            gray = cv2.cvtColor(im,cv2.COLOR_BGR2GRAY)
            faces = faceCascade.detectMultiScale(
                gray,
                scaleFactor = 1.2,
                minNeighbors = 5,
                minSize = (30, 30),
                flags = cv2.CASCADE_SCALE_IMAGE
            )
            detectFace = False
            
            for(x,y,w,h) in faces:
                detectFace = True
                cv2.rectangle(im,(x,y),(x+w,y+h),(225,0,0),2)
                #get kordinat head position
                corX = x+int(w/2)
                corY = y+int(h/3)
                cv2.putText(im,".", (corX,corY),font,2,(0,0,255), 2)
                
                if corX < 80 or corX > 560:
                    print("out of frame")
                    cv2.putText(im,"out of frame", (0,0),font,1,(0,255,0), 2)
                else:
                    #corX = corX - 80  #nol kan posisi x
                    
                    a = int(corY/60)  
                    b = int(corX/60)  
                    if a < 7:
                        a = a + 1  #1 = kalibrasi posisi pixel panas karena posisi thermal cam berada geser bawah dr poisi lensa camera
                    if b < 7:
                        b = b + 1  #1 = kalibrasi posisi pixel panas karena posisi thermal cam berada geser kanan dr poisi lensa camera
                    print("koordinat Y : ",a)
                    print("koordinat X : ",b)
                    print()
                    if a < 8 and b < 8:
                        flagCountTemp = flagCountTemp + 1
                        
                        if flagCountTemp > 20:
                            suhuTubuh = 0.0
                            for i in range(10):
                                dataTemp = sensor.readPixels()
                                #print(dataTemp)
                                print("nilai array : ",mapAddr[a][b])
                                print("temp capture : ",dataTemp[mapAddr[a][b]])
                                suhuTubuh = suhuTubuh + (dataTemp[mapAddr[a][b]] + kalibrasi_suhu)
                                time.sleep(0.1)
                                
                            suhuTubuh = suhuTubuh / 10
                            if suhuTubuh < suhu_minimal:
                                suhuTubuh = suhu_minimal

                            if suhuTubuh > 37.5:
                                suhuTinggi = True
                            else:
                                suhuTinggi = False
                            flagTemp = True
                            flagCountTemp = 0
                        
                        if flagTemp:
                            if suhuTubuh > 0:
                                                                    #15 posisi tulisan suhu
                                cv2.putText(im,str(suhuTubuh)+"C", (corX+15,corY-15),font,1,(0,255,0), 2)
                            else:
                                cv2.putText(im,"deteksi suhu", (corX+15,corY-15),font,1,(0,255,0), 2)

                    else:
                        print("out of range")
                        cv2.putText(im,"out of range", (0,0),font,1,(0,255,0), 2)
                
                
                Id, conf = recognizer.predict(gray[y:y+h,x:x+w])
                if(conf>accuracy):
                    old_id = face_id
                    #old_name = nama
                        
                    for i in range(len(id_list)):
                        #print(i)
                        if Id == int(id_list[i]):
                            nama = nama_list[i]
                            #print(nama)
                            face_id = int(id_list[i])
                            
                    if old_id == face_id:
                        count_face = count_face + 1
                        print("face sama dengan sebelumnya")
                        
                    if count_face >= 10:
                        #cv2.putText(im,nama+"(conf "+str(round(conf,2))+")", (x,y+h),font,1,(0,255,0), 2)
                        cv2.putText(im,nama, (x,y+h),font,1,(0,255,0), 2)
                    else:
                        cv2.putText(im,"identifikasi wajah", (x,y+h),font,1,(0,255,0), 2)
                else:
                    print("nama ",nama)
                    face_id = 0
                    count_face = 0
                    #cv2.putText(im,nama+"(conf "+str(round(conf,2))+")", (x,y+h),font,1,(0,255,0), 2)
                    cv2.putText(im,nama, (x,y+h),font,1,(0,255,0), 2)
                    pygame.mixer.init()
                    pygame.mixer.music.load("tidakterdaftar.mp3")
                    pygame.mixer.music.set_volume(1.0)
                    pygame.mixer.music.play()

                    while pygame.mixer.music.get_busy() == True:
                        print("play mp3")
                        pass
                #cv2.putText(im,nama+"(conf "+str(round(conf,2))+")", (x,y+h),font,1,(0,255,0), 2)
                print("count_face ",count_face)
                
            if sendDataAbsen:
                cv2.putText(im,sudahAbsen, (10,450),font,1,(0,0,255), 2)
            else:
                if count_face >= 10:
                    if face_id > 0 and nama != "Unknown" and suhuTubuh >= suhu_minimal:
                        print("Kirim data ke server...")
                        print("Nama : "+nama)
                        print("Face ID : "+str(face_id))
                        print(time.strftime("%d %B %Y %H:%M", time.localtime(time.time())))
                        try:
                            send_absen = requests.post(url_absensi, data={"faceid":face_id, "key":KEY, "iddev":iddev, "suhu":suhuTubuh}, timeout=5).json()
                            print(json.dumps(send_absen, indent=4, sort_keys=True))
                            if send_absen['status'] == "success":
                                cv2.putText(im, send_absen['waktu'], (10,400),font,1,(0,0,255), 2)
                                
                            sudahAbsen = send_absen['ket']
                            cv2.putText(im,send_absen['ket'], (10,450),font,1,(0,0,255), 2)
                            haveSend = True
                            
                            #capture disini
                        except requests.exceptions.Timeout as e1:
                            print("requests send absen time out")
                        except requests.exceptions.RequestException as e2:
                            print("requests send absen connection aborted")
                            print("check the internet connection")
                        print()
            
            cv2.imshow('face recognition',im)
            
            if cv2.waitKey(10) & 0xFF==ord('q'):
                break
            if haveSend:
                sendDataAbsen = True
                if suhuTinggi:
                    pygame.mixer.init()
                    pygame.mixer.music.load("suhutinggi.mp3")
                    pygame.mixer.music.set_volume(1.0)
                    pygame.mixer.music.play()

                    while pygame.mixer.music.get_busy() == True:
                        print("play mp3")
                        pass
                else:
                    cv2.waitKey(3000)
            if detectFace == False:
                flagCountTemp = 0
                flagTemp = False
                sendDataAbsen = False
                count_face = 0
                face_id = 0
                print("no face detect")
            
    cam.release()
    cv2.destroyAllWindows()

##################################
    

    
def exitApps():
    cv2.destroyAllWindows()
    exit()

btnAdd = Button(root, text="Tambah Face ID", width=15, height=2, bg="lightblue", fg="darkblue",
             font=("arial", 13, "italic"), command=get_ID).place(x=50,y=45)

btnDel = Button(root, text="Hapus Face ID", width=15, height=2, bg="lightblue", fg="darkblue",
             font=("arial", 13, "italic"), command=del_ID).place(x=250,y=45)

space = Label(root, text="__________________________________________",
              font=("arial", 15, "bold"), fg="red").place(x=8,y=100)

mainTrain = Label(root, text="Train Face ID", font=("arial", 16, "bold"),
                  fg="steelblue").place(x=162,y=145)

btnTrain = Button(root, text="Train", width=15, height=2, bg="lightblue", fg="darkblue",
            font=("arial", 13, "bold"), command=train).place(x=140,y=190)


space2 = Label(root, text="__________________________________________",
              font=("arial", 15, "bold"), fg="red").place(x=8,y=255)

mainAbsen = Label(root, text="Absensi Face ID dengan suhu", font=("arial", 20, "bold"),
                  fg="steelblue").place(x=60,y=300)

btnFaceAbsen = Button(root, text="Absensi Face", width=20, height=3, bg="lightblue", fg="darkblue",
            font=("arial", 13, "bold"), command=absensi).place(x=120,y=350)


btnExit = Button(root, text="Exit", width=10, height=1, bg="lightblue", fg="darkblue",
            font=("arial", 12, "bold"), command=exitApps).place(x=180,y=520)

Copyright = Label(root, text="2020",
              font=("arial", 12, "bold"), fg="red").place(x=120,y=600)

root.mainloop()


