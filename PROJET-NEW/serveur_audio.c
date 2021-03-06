/* Serveur streaming : associ� au programme client client_audio.c */
/* Choisir pour client_audio le fichier mono bbc.wav sur 16 bits */ 
/* La partie que vous devez completer se situe a partir de la ligne 212 */
/* La fonction main_wave doit etre simplement modifiee pour recevoir le */
/* nom du media file. Actuellement celui-ci est code en dur a� la ligne 61 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include "hacking.h"
#include "hacking-network.h"

#include <memory.h>

#include <unistd.h>
#include <fcntl.h>
#include <sys/types.h>
#include <sys/ioctl.h>
#include "soundcard.h"
//#include </full/path/to/CoreAudio.h> 

#define RATE 44100  /* Taux d'�chantillonnage par d�faut 44100 */
#define SIZE 16     /* taille en bits d'un �chantillon: 8 or 16 bits */
#define CHANNELS 1  /* 1 = mono 2 = stereo */
#define LINELENGTH 88200  /* Buffer : les paquets font 2048 */

#define PORT 7890	// le client devrGa se connecter au port 7890


/* Ce buffer g�re les donn�es audio par paquet de longueur LINELENGTH pour la lecture compl�te du fichier son */

unsigned char buf[LINELENGTH];

float LittleEndianIntRead(int num_bytes, FILE* pfile,unsigned char *aby,unsigned char *bby) {
int i;int a;
long long int s=0;
for (i=0;i<num_bytes;i++){
    
    a=getc(pfile);
    s+=a << (i*8);
    /* Les donn�es sont cod�es ici en 16 bits par �chantillon : i=0 8 bits de poids faibles i=1 les 8
    autres : il s'agit ici de cr�er le flux envoy� au HP ou BIEN AU PROGRAMME CLIENT */  
    if(i==0) *aby=(unsigned char) a;
    if(i==1) *bby=(unsigned char) a;
    }
    /* On r�cup�re les donn�es sous la forme de deux �chantillons par donn�es */

    /* Pour visualisation avec gnuplot (phase de test): donn�es formats float */
    
   if (s > (1<<(num_bytes*8-1))) {
        return (float)(s-(1<<(num_bytes*8)));
   }
   else{
        return(float)(s);
   }
   }
   
void main_wave(int new_sockfd, char pszFileName[] ){
    //char pszFileName[]="bbc.wav";  /* NOM du fichier audio : celui-ci doit correspondre � la requ�te */
    
    FILE* pFile=NULL;
    char pbType[4];
    int nSampleRate;
    short nChannels;
    short nBitsPerSample;
    int nSamples;
    int nTotalChunkSize;
    char found;
    int nRead;
    float** ppfData;
    int ch;
    int bin;
    unsigned char aby,bby;
    unsigned char temp;
    
    pFile=fopen(pszFileName,"rb");
    if(pFile==NULL) {
        printf("Impossible d'ouvrir le fichier : \"%s\"",pszFileName);
	return;
    }
     rewind(pFile);
     fseek(pFile,4,SEEK_CUR);
     fseek(pFile,4,SEEK_CUR);
     fseek(pFile,4,SEEK_CUR);
     fseek(pFile,4,SEEK_CUR);
     fseek(pFile,4,SEEK_CUR);
     fseek(pFile,2,SEEK_CUR);
     
     fread(&nChannels,2,1,pFile);
     fread(&nSampleRate,4,1,pFile);
     printf("Nombre de canaux : %d\n",nChannels);
     printf("Taux d'echantillonnage : %d\n",nSampleRate);
     fseek(pFile,4,SEEK_CUR);
     fseek(pFile,2,SEEK_CUR);
     
     fread(&nBitsPerSample,2,1,pFile);
     printf("Nombre de bits par echantillon : %d\n",nBitsPerSample);
     
     nTotalChunkSize=0;
     found=0;
     
     do{
         nRead = fread(pbType,4,1,pFile);
	 nRead = fread(&(nTotalChunkSize),4,1,pFile);
	  if((pbType[0]=='d') && (pbType[1]=='a') && (pbType[2]=='t') && (pbType[3]=='a')){
	  found=1;
	  printf("%d\n", found);
	  break;
	  }
	  fseek(pFile,nTotalChunkSize,SEEK_CUR);
     }while(nRead);
     
     if(found){
         nSamples=(nTotalChunkSize)/(nBitsPerSample/8*nChannels);
	 
	 ppfData=malloc(sizeof(float*)*nChannels);
	 for (ch=0; ch<nChannels;ch++) {
	   ppfData[ch]=malloc(sizeof(float)*nSamples);
	 }
	 
	 switch(nBitsPerSample) {
	   case 8 :
	   case 16 :
	   case 24 :
	   case 32 :
	   	     printf("Ce format est pris en charge !\n");
 
		while(1)
		  {
		  
	             for (bin=0;bin<nSamples;bin++) {
		      
			temp=LittleEndianIntRead(nBitsPerSample/8,pFile,&aby,&bby);
		     
		     /* On remplit le buffer avec les donn�es : 8 bits de poids faibles suivis des 8
		        autres : buf sera ensuite envoy� au HP ou sur le flux � destination du client */
		     /* L'astuce est de lire le flux de donn�es : et d'envoyer */
		     /* les donn�es par paquet de 1024 */
		     /* Il est donc inutile de r�server un buffer complet 
		     	pour la lecture du fichier */ 
		     		    
		     	buf[(2*bin)%LINELENGTH]=aby;
		     	buf[(2*bin+1)%LINELENGTH]=bby;
		     	if (bin!=0 && (2*bin)%LINELENGTH==0)
		        	send(new_sockfd,buf,LINELENGTH,0);
		  
		        }
		     }
		 
		      
		     break;
            default:
	             printf("Ce format n'est pas prise en charge !");
		     break;
		     }
   }
   for(ch=0;ch<nChannels;ch++) {
       free(ppfData[ch]);
    }
    free(ppfData);
    fclose(pFile);
    
    }   
     


int main(void) {
	int sockfd, new_sockfd;  // listen on sock_fd, new connection on new_fd
	struct sockaddr_in host_addr, client_addr;	// my address information
	socklen_t sin_size;
	int recv_length=1, yes=1;
	char buffer[1024]; /* pour recevoir le lux streaming */
	char buf1[256];  /* Pour recevoir les donn�es information */
	int longueur;
	int j, nbpaquets,cptpaquets;
 
		

	if ((sockfd = socket(PF_INET, SOCK_STREAM, 0)) == -1)
		fatal("in socket");

	if (setsockopt(sockfd, SOL_SOCKET, SO_REUSEADDR, &yes, sizeof(int)) == -1)
		fatal("setting socket option SO_REUSEADDR");
	
	host_addr.sin_family = AF_INET;		 // host byte order
	host_addr.sin_port = htons(PORT);	 // short, network byte order
	host_addr.sin_addr.s_addr = INADDR_ANY; // automatically fill with my IP
	memset(&(host_addr.sin_zero), '\0', 8); // zero the rest of the struct

	if (bind(sockfd, (struct sockaddr *)&host_addr, sizeof(struct sockaddr)) == -1)
		fatal("binding to socket");

	if (listen(sockfd, 5) == -1)
		fatal("listening on socket");

	while(1) {    // Accept loop
		sin_size = sizeof(struct sockaddr_in);
		new_sockfd = accept(sockfd, (struct sockaddr *)&client_addr, &sin_size);
		if(new_sockfd == -1)
			fatal("accepting connection");
		printf("server: got connection from %s port %d\n",inet_ntoa(client_addr.sin_addr), ntohs(client_addr.sin_port));
		
		
		
		send_string(new_sockfd, "Hello World! Quel fichier audio, please?\r\n");
		
		/*************************************************************/
		/*  VOUS INTERVENEZ ICI                                      */
		/*  Cette partie du programme doit                           */
		/*      - receptionner le nom du fichier audio envoye par    */
		/*        client_audio                                       */
		/*      - afficher le nom du fichier audio demande           */
		/*      - lancer main_wave(new_sockfd,nom_fichier_audio) pour lire les paquets */
		/*        jusqu'a la fin du fichier audio ou bien la         */
		/*        la deconnexion du client                           */
		/*************************************************************/
		printf("On attend la demande\n");
		//r�ception du fichier audio
		recv_line(new_sockfd, buffer);
		//on affiche le fichier demand�
		printf("Vous avez demande : %s\n", buffer);

		main_wave(new_sockfd,buffer);
	
		
		}
		
		close(new_sockfd);
	
	return 0;
}

