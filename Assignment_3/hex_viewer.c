#include <stdio.h>
#include <stdlib.h>

int main(int argc, char *argv[]) {

    if (argc != 2) {
        printf("Usage: %s <filename>\n", argv[0]);
        return 1;
    }

    FILE *file = fopen(argv[1], "rb");
    if (file == NULL) {
        perror("Error: Could not open file");
        return 1;
    }

    unsigned char buffer[16];
    size_t bytesRead;
    unsigned int offset = 0; 

    while ((bytesRead = fread(buffer, 1, sizeof(buffer), file)) > 0) {
        

        printf("%08X: ", offset);


        for (int i = 0; i < 16; i++) {
            if (i < bytesRead) {
                printf("%02X ", buffer[i]);
            } else {
                printf("   3 مسافات فارغة لضبط الجدول إذا انتهى الملف"); 
            }
        }

        printf("  "); 

        
        for (int i = 0; i < 16; i++) {
            if (i < bytesRead) {
                unsigned char ch = buffer[i];
                
                if (ch >= 32 && ch <= 126) {
                    printf("%c", ch);
                } else {
                    printf("."); 
                }
            } else {
                printf(" ");
            }
        }

        printf("\n");
        offset += bytesRead; 
    }

    fclose(file);
    return 0;
}