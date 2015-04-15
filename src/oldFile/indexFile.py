from libxmp import *
import sys

file = sys.argv[1]
print file


# Read file
xmpfile = XMPFiles( file_path=file, open_forupdate=True )

# Get XMP from file.
#xmp = xmpfile.get_xmp()
xmp = XMPMeta()
#ex = xmp["http://www.example.org"]
print xmp


# Change the XMP property
xmp.set_property( consts.XMP_NS_DC, 'format','application/vnd.adobe.illustrator' )

# Check if XMP document can be written to file and write it.
if xmpfile.can_put_xmp(xmp):
        xmpfile.put_xmp(xmp)

# XMP document is not written to the file, before the file
# is closed.
xmpfile.close_file()