<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nette\Utils\ImageColor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $modelLabel = 'Manage Post';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create News Post')
                    ->description('Only Genuine Source News')
                    ->schema([
                        Select::make('category_id')
                            ->label('Category')
                            // ->searchable() // for large data collection
                            // ->options(Category::all()->pluck('name', 'id')),  // bad practice
                            ->relationship('category','name'),
                        TextInput::make('title')->rules('min:3|max:160')->required(),
                        TextInput::make('slug')->unique(ignoreRecord: true)->required(),
                        ColorPicker::make('color')->required(),
                        MarkdownEditor::make('content')->required()->columnSpanFull(),
                    ])->columnSpan(2)->columns(2),
                Group::make()->schema([
                    Section::make('Post Thumbnail')
                        ->description('Post Thumbnail & Images')
                        ->collapsible()
                        ->schema([
                            FileUpload::make('thumbnail')
                                ->disk('public')
                                ->directory('thumbnails')
                                ->columnSpan('full')
                                ->rules('image|mimes:png,jpg,jpeg,gif')
                        ])->columnSpan(1)->columns(1),
                    section::make('Meta, Tags & Publish')
                        ->description('Post Publish & Tags related')
                        ->schema([
                            TagsInput::make('tags')->required(),
                            Toggle::make('published')->inline(false),
                        ])
                ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('S.n')->sortable(),
                ImageColumn::make('thumbnail'),
                ColorColumn::make('color')->toggleable(),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('category.name')->sortable()->searchable(),
                TextColumn::make('tags')->sortable()->searchable()->toggleable(),
                ToggleColumn::make('published'),
                TextColumn::make('created_at')->label('publish on')->date()
                ->sortable()->searchable()->toggleable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
